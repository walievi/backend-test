<?php

namespace App\UseCases\Account;

use Throwable;
use App\UseCases\BaseUseCase;
use App\Repositories\User\Find;
use App\Repositories\Account\Create;
use App\Exceptions\InternalErrorException;
use App\Integrations\Banking\Account\Create as BankingCreate;

/**
 * Sugestões de melhorias:
 *
 * - Falta validação de transação para garantir atomicidade entre register() e store()
 * - Não há retry policy para chamadas ao BaaS
 * - Falta validação de status da conta antes de criar
 * - Não há logs específicos para monitoramento de performance
 * - Não há tratamento específico para diferentes tipos de erros do BaaS
 */

class Register extends BaseUseCase
{
    /**
     * Id do usuário
     *
     * @var string
     */
    protected string $userId;

    /**
     * Id da empresa
     *
     * @var string
     */
    protected string $companyId;

    /**
     * Usuário
     *
     * @var array
     */
    protected array $user;

    /**
     * Conta
     *
     * @var array
     */
    protected array $account;

    public function __construct(string $userId, string $companyId)
    {
        $this->userId    = $userId;
        $this->companyId = $companyId;
    }

    /**
     * Encontra o usuário
     *
     * @return void
     */
    protected function findUser(): void
    {
        $user = (new Find($this->userId, $this->companyId))->handle();
        if (is_null($user)) {
            throw new InternalErrorException(
                'USER_NOT_FOUND',
                146001001
            );
        }

        $this->user = $user;
    }

    /**
     * Cria a conta
     *
     * @return void
     */
    protected function register(): void
    {
        $this->account = (new BankingCreate(
            $this->user['name'],
            $this->user['document_number'],
            $this->user['email']
        ))->handle();
    }

    /**
     * Registra no banco de dados
     *
     * @return void
     */
    protected function store(): void
    {
        (new Create($this->userId, $this->account['data']['id']))->handle();
    }

    /**
     * Cria a conta
     */
    public function handle(): void
    {
        try {
            $this->findUser();
            $this->register();
            $this->store();
        } catch (Throwable $th) {
            $this->defaultErrorHandling(
                $th,
                [
                    'userId' => $this->userId,
                ]
            );
        }
    }
}
