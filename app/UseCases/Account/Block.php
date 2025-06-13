<?php

namespace App\UseCases\Account;

use Throwable;
use App\UseCases\BaseUseCase;
use App\Repositories\Account\UpdateStatus as RepositoryUpdateStatus;
use App\Integrations\Banking\Account\UpdateStatus as IntegrationUpdateStatus;

/**
 * Sugestões de melhorias:
 *
 * - Falta validação de transação para garantir atomicidade entre updateDatabase() e updateStatus()
 * - Não há validação de status atual da conta antes de bloquear
 * - Falta logs específicos para auditoria de bloqueio
 * - Não há validação de permissões específicas para bloqueio
 * - Não há tratamento específico para diferentes tipos de erros do BaaS
 */

class Block extends BaseUseCase
{
    /**
     * Id do usuário
     *
     * @var string
     */
    protected string $userId;

    /**
     * Conta
     *
     * @var array
     */
    protected array $account;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Atualiza no banco de dados
     *
     * @return void
     */
    protected function updateDatabase(): void
    {
        (new RepositoryUpdateStatus($this->userId, 'block'))->handle();
    }

    /**
     * Atualiza a conta
     *
     * @return void
     */
    protected function updateStatus(): void
    {
        $this->account = (new IntegrationUpdateStatus($this->userId, 'block'))->handle();
    }

    /**
     * Bloqueia a conta
     */
    public function handle(): void
    {
        try {
            $this->updateDatabase();
            $this->updateStatus();
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
