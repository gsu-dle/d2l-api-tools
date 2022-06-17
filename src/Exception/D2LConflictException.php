<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * The response body may contain an explanatory message. Your action required access to a resource and the access 
 * resulted in an access conflict. This can occur in cases where your action seeks to create a resource by name, where a
 * resource with that name already exists.
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LConflictException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(public D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: '409 Conflict'
        );
    }
}
