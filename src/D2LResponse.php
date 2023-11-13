<?php

declare(strict_types=1);

namespace GAState\Tools\D2L;

use GAState\Tools\D2L\Exception\{
    D2LBadRequestException,
    D2LConflictException,
    D2LForbiddenException,
    D2LGeneralServiceErrorException,
    D2LInvalidTokenException,
    D2LMethodNotAllowedException,
    D2LTimestampOutOfRangeException,
    D2LNotFoundException,
    D2LResponseException,
    D2LServiceErrorException,
    D2LTooManyRequestsException,
    D2LUnsupportedMediaTypeException
};

/**
 * @package GAState\Tools\D2L
 * @access  public
 */
class D2LResponse
{
    /**
     * @var D2LRequest $request
     */
    public D2LRequest $request;

    /**
     * @var int $statusCode
     */
    public int $statusCode;

    /**
     * @var array<string,string> $headers
     */
    public array $headers;

    /**
     * @var string|null $rawData
     */
    public string|null $rawData;

    /**
     * @var array<mixed>|object|string|int|null $data
     */
    public array|object|string|int|null $data;

    /**
     * @param D2LRequest $request
     * @param int $statusCode
     * @param array<string,string> $headers
     * @param string|null $data
     */
    public function __construct(
        D2LRequest $request,
        int $statusCode,
        array $headers,
        ?string $data
    ) {
        $this->request = $request;
        $this->statusCode = $statusCode;
        $this->initHeaders(headers: $headers);
        $this->initData(data: $data);
    }

    /**
     * @param array<int|string,string|array<string>> $headers
     * 
     * @return void
     */
    protected function initHeaders(array &$headers): void
    {
        $this->headers = [];
        foreach ($headers as $name => $value) {
            while (is_array($value)) {
                $value = array_pop($value);
            }
            $this->headers[strtolower(strval($name))] = strval($value);
        }
    }

    /**
     * @param string|null $data
     * 
     * @return void
     */
    protected function initData(?string $data): void
    {
        $this->rawData = $data;

        if ($data !== null && strlen($data) > 0) {
            $contentType = $this->headers["content-type"] ?? '';
            if (strstr($contentType, 'application/json') !== false) {
                $jsonData = json_decode($data);
                if (is_array($jsonData) || is_object($jsonData)) {
                    $data = $jsonData;
                }
            } else if ($contentType === 'file') {
                $data = intval($data);
            }
        }

        $this->data = $data;
    }

    /**
     * @return D2LResponse
     */
    public function verify(): D2LResponse
    {
        switch ($this->statusCode) {
            case 200: // OK
                $contentType = $this->headers["content-type"] ?? '';
                if (strstr($contentType, 'application/json') !== false && $this->data === null) {
                    // TODO: need better exception?
                    throw new D2LGeneralServiceErrorException(response: $this);
                }
                return $this;
            case 201: // Created
                $contentType = $this->headers["content-type"] ?? '';
                if (strstr($contentType, 'application/json') !== false && $this->data === null) {
                    // TODO: need better exception?
                        throw new D2LGeneralServiceErrorException(response: $this);
                }
                return $this;
            case 400: // Bad Request
                throw new D2LBadRequestException(response: $this);
            case 403: // Forbidden
                if (preg_match('/Timestamp out of range/', $this->rawData ?? '') === 1)
                    throw new D2LTimestampOutOfRangeException(response: $this);
                else if (preg_match('/Invalid token/', $this->rawData ?? '') === 1)
                    throw new D2LInvalidTokenException(response: $this);
                else
                    throw new D2LForbiddenException(response: $this);
            case 404: // Not Found
                throw new D2LNotFoundException(response: $this);
            case 405: // Method Not Allowed
                throw new D2LMethodNotAllowedException(response: $this);
            case 409: // Conflict
                throw new D2LConflictException(response: $this);
            case 415: // Unsupported Media Type
                throw new D2LUnsupportedMediaTypeException(response: $this);
            case 429: // Too many requests
                throw new D2LTooManyRequestsException(response: $this);
            case 500: // General service error
                throw new D2LGeneralServiceErrorException(response: $this);
            case 504: // Service Error
                throw new D2LServiceErrorException(response: $this);
        }

        if ($this->statusCode >= 500)
            throw new D2LGeneralServiceErrorException(response: $this);
        else if ($this->statusCode >= 400)
            throw new D2LBadRequestException(response: $this);
        else
            throw new D2LResponseException(response: $this, message: 'Unknown error');
    }
}
