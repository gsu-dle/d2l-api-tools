<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * If an API caller exceeds its allowed calling rate, the back-end service may respond with a 429 status code. If you 
 * encounter a result like this, you must wait until your limit has been reset before the back-end service will once 
 * again process your API calls.
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LTooManyRequestsException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(public D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: '429 Too Many Requests'
        );
    }
}
