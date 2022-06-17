<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * Response body contains Timestamp out of range, followed by the server time (UTC Unix timestamp). The service expects 
 * a different time provided with your action and cannot accept your request: this can  occur if the client clock has 
 * skewed significantly from the service’s clock. You should re-calculate the skew and retry the call using the new 
 * time. (Note our client libraries may be able to take care of calculating and maintaining clock skew for you.)
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LTimestampOutOfRangeException extends D2LForbiddenException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(public D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: 'Timestamp out of range'
        );
    }
}
