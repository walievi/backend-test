<?php

namespace App\UseCases\Company;

use Throwable;
use App\UseCases\BaseUseCase;
use App\Repositories\Company\Find;

/**
 * Sugestões de melhorias:
 *
 * - Falta validação de permissões para visualizar empresa
 * - Não há cache para dados frequentemente consultados
 * - Falta logs específicos para auditoria de consulta
 * - Falta validação de campos de retorno
 * - Não há validação de status da empresa
 * - Falta validação de relacionamentos
 * - Não há validação de dados sensíveis
 */

class Show extends BaseUseCase
{
    /**
     * Id do empresa
     *
     * @var string
     */
    protected string $id;

    /**
     * Empresa
     *
     * @var array
     */
    protected array $company;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Encontra a empresa
     *
     * @return void
     */
    protected function find(): void
    {
        $this->company = (new Find($this->id))->handle();
    }

    /**
     * Retorna usuário, se encontrado
     */
    public function handle(): ?array
    {
        try {
            $this->find();
        } catch (Throwable $th) {
            $this->defaultErrorHandling(
                $th,
                [
                    'id' => $this->id,
                ]
            );
        }

        return $this->company;
    }
}
