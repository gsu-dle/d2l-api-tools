<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * Response body contains Invalid Token. Authentication signatures don’t match for some reason: this can occur if the 
 * user (for the calling user context) has changed his or her password, reset tokens, or otherwise disabled cached keys.
 * You should discard your stored User ID-key pair, and offer the authentication login process to the user again.
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LInvalidTokenException extends D2LForbiddenException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(public D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: 'Invalid token'
        );
    }
}
