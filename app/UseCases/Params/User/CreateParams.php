<?php

namespace App\UseCases\Params\User;

use App\UseCases\Params\BaseParams;

/**
 * Sugestões de melhorias:
 *
 * - Falta validação de formato de email
 * - Não há validação de força da senha
 * - Falta validação de formato do CPF
 * - Não há validação de tamanho máximo dos campos
 * - Falta validação de caracteres especiais
 * - Falta validação de tipo de usuário válido
 * - Não há validação de relacionamento com empresa
 */

class CreateParams extends BaseParams
{
    /**
     * Id da empresa
     *
     * @var string
     */
    protected string $companyId;

    /**
     * Nome do usuário
     *
     * @var string
     */
    protected string $name;

    /**
     * CPF do usuário
     *
     * @var string
     */
    protected string $documentNumber;

    /**
     * Email
     *
     * @var string
     */
    protected string $email;

    /**
     * Senha
     *
     * @var string
     */
    protected string $password;

    /**
     * Tipo
     *
     * @var string
     */
    protected string $type;

    public function __construct(
        string $companyId,
        string $name,
        string $documentNumber,
        string $email,
        string $password,
        string $type
    ) {
        $this->companyId      = $companyId;
        $this->name           = $name;
        $this->documentNumber = $documentNumber;
        $this->email          = $email;
        $this->password       = $password;
        $this->type           = $type;
    }
}
