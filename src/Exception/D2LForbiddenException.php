<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * The application or calling user context does not have the permissions required for the attempted action. This can 
 * occur if, for instance, you attempt an action to update course content within a user context that does not have the 
 * permission to edit the course’s content. You should notify the user about the lack of permission: users require the 
 * same permission to act through the Learning Framework API that they would for a similar action through the service’s 
 * standard web application.
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LForbiddenException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     * @param string $message
     */
    public function __construct(public D2LResponse $response, string $message = '')
    {
        parent::__construct(
            response: $response,
            message: '403 Forbidden' . ($message !== '' ? ' - ' . $message : '')
        );
    }
}
