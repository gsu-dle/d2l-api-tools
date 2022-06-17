<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * @package GAState\Tools\D2L\Exception
 * @access public
 */
class D2LResponseException extends D2LException
{
    /**
     * @param D2LResponse $response
     * @param string $message
     */
    public function __construct(public D2LResponse $response, string $message)
    {
        parent::__construct(message: $message);
    }
}
