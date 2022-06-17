<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * The response body may contain an explanatory message. If the action you’re using expects input, and your Content-Type
 * header of your request specifies a media type that the back-end service cannot find a request handler for, then the 
 * service may return this error. This may occur, for example, if you use an action which requires application/json 
 * input, and your request does not specify this media type (or provides another, like plain/text).
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LUnsupportedMediaTypeException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(public D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: '415 Unsupported Media Type'
        );
    }
}
