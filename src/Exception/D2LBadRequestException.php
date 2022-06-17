<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * In your action, you provided an invalid parameter value or a JSON input data block with one or more  invalid values. 
 * In some cases, you may have attempted an action in a calling context that renders it invalid.
 * 
 * Notice that your input data was successfully bound to the data objects the back-end service expected to receive, but 
 * the values you provided in the input data are invalid for one reason or another (see the 404 response below, as 
 * well).
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LBadRequestException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(public D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: '400 Bad Request'
        );
    }
}
