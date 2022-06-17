<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Exception;

use GAState\Tools\D2L\D2LResponse;

/**
 * The response body may contain an explanatory message, or may not. Your action identified (either in the URL route, or
 * with a parameter) a resource that the service cannot locate. You should notify the user about the missing resource.
 * 
 * Note that when you make an API call, the back-end service looks for the service handler associated with the API route
 * that you called (for example, /d2l/api/versions/) and associated with the incoming data objects that service handler 
 * expects. This means that the back-end service deserializes and binds your provided parameterized data (query 
 * parameters and provided JSON data) as part of the same process that “looks for the resource handler” for your API 
 * call. If the back-end service cannot, for some reason, succeed at de-serializing and binding your parameters, this
 * can cause the service to conclude that it “cannot find the resource”, and thus return a 404 error.
 * 
 * If you’re receiving a 404 when calling the API, carefully verify that you’re providing:
 * - The correct API route (including any trailing slash).
 * - Correct values for all the in-route variable values (version number, org unit identifiers, and so on).
 * - Valid field data for the JSON structures you’re expected to provide: this is especially true of JSON properties 
 *   that have complex, parsed values (for example, “valid email addresses”, “valid URLs”, “valid timestamps”, and so
 *   on).
 * 
 * Finally, note that the back-end service may not have all the Brightspace functionality enabled to provide access to 
 * all the APIs contained in this API reference documentation. If you attempt to make an API call to an action for which
 * the underlying supporting functionality has not been enabled, your call can result in a 404 status code.
 * 
 * @package GAState\Tools\D2L\Exception
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#returned-resources
 */
class D2LNotFoundException extends D2LResponseException
{
    /**
     * @param D2LResponse $response
     */
    public function __construct(public D2LResponse $response)
    {
        parent::__construct(
            response: $response,
            message: '404 Not Found'
        );
    }
}
