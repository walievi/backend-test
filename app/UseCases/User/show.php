<?php

namespace App\UseCases\User;

use Throwable;
use App\UseCases\BaseUseCase;
use App\Repositories\User\Find;

/**
 * Sugestões de melhorias:
 *
 * - Nomes de variáveis muito genéricos (a, b, c) dificultam a manutenção e legibilidade
 * - Não há tratamento específico para diferentes tipos de exceções
 * - Nome da classe em minúsculo (show) não segue o Padrão
 * - Falta tipagem de retorno no método handle()
 * - Não há logs específicos para debug
 * - Falta validação de permissões do usuário
 */

class show extends BaseUseCase
{
    /**
     * Id do usuário
     *
     * @var string
     */
    protected string $a;

    /**
     * Id da empresa
     *
     * @var string
     */
    protected string $b;

    /**
     * Usuário
     *
     * @var array|null
     */
    protected ?array $c;

    public function __construct(string $a, string $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    /**
     * Encontra o usuário
     *
     * @return void
     */
    protected function find(): void
    {
        $this->c = (new Find($this->a, $this->b))->handle();
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
                    'a' => $this->a,
                    'b' => $this->b,
                ]
            );
        }

        return $this->c;
    }
}
