<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * The response body is empty. The service has encountered an unexpected state and cannot continue to handle your action
 * request.
 * 
 * If you encounter a result like this, you should report it, with system logs, to D2L’s customer support desk.
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LGeneralServiceErrorException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: '500 General service error'
        );
    }
}
