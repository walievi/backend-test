<?php

namespace App\UseCases;

use App\Traits\Logger;
use App\Traits\Instancer;

/**
 * Sugestões de melhorias:
 *
 * - Falta interface para definir contrato dos UseCases
 * - Não há injeção de dependência para serviços externos
 * - Falta validação de permissões centralizada
 * - Não há tratamento de exceções específico por tipo
 * - Não há validação de parâmetros centralizada
 * - Falta logging centralizado para monitoramento
 * - Não há métricas de performance centralizadas
 */

abstract class BaseUseCase
{
    use Logger;
    use Instancer;
}
