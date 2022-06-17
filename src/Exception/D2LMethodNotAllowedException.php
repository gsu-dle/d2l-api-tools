<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * The response body may contain an explanatory message. You attempted to use an HTTP method that’s not permitted with a
 * route that does exist for use with other methods. (For example, this can occur if you attempt to DELETE a resource 
 * that can only be retrieved with GET.)
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LMethodNotAllowedException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(public D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: '405 Method Not Allowed'
        );
    }
}
