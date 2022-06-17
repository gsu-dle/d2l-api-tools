<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * @package GAState\Tools\D2L\Exception
 * @access public
 */
class D2LExpectedObjectException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(public D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: 'Expected response->data to be an object'
        );
    }
}
