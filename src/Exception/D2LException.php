<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use Exception;
use Throwable;

/**
 * @package GAState\Tools\D2L\Exception
 * @access public
 */
class D2LException extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct(message: $message, code: $code, previous: $previous);
    }
}
