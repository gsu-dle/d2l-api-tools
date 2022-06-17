<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * The respnose body may contain an explanatory message. Typically, if the service handling your request encountered a 
 * service error from another internal service while trying to fulfill your request, it may send back this error.
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LServiceErrorException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: '504 Service Error'
        );
    }
}
