<?php

declare(strict_types=1);

namespace GAState\Tools\D2L;

use GAState\Tools\D2L\{
    Exception\D2LException,
    Model\API\PagedResultSetModel,
    Model\API\ObjectListPageModel
};
use InvalidArgumentException;
use ReflectionProperty;

/**
 * @package GAState\Tools\D2L
 * @access public
 */
class D2L
{
    /**
     * @param string $date
     * 
     * @return string|null
     */
    public static function convertToUTC(string $date): ?string
    {
        $time = strtotime($date);
        if ($time === false) {
            return null;
        }

        $dateDefaultTimezone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $date = date('Y-m-d', $time) . 'T' . date('H:i:s', $time) . '.000Z';
        date_default_timezone_set($dateDefaultTimezone);
        return $date;
    }

    /**
     * @param string $host
     * @param string $appID
     * @param string $appKey
     * @param string $userID
     * @param string $userKey
     * @param string $oauthToken
     * @param array<string,string>|null $versions
     * @param int $rootOrgUnit
     */
    public function __construct(
        private string $host,
        private string $appID = '',
        private string $appKey = '',
        private string $userID = '',
        private string $userKey = '',
        private string $oauthToken = '',
        public ?array $versions = null,
        public int $rootOrgUnit = 0
    ) {
        if (($appID === '' || $appKey === '' || $userID === '' || $userKey === '') && $oauthToken === '') {
            throw new InvalidArgumentException('Missing required authentication parameters', -1);
        }

        $this->versions = $versions ?? $this->getVersions();
    }

    /**
     * @return array<string,string>
     */
    public function getVersions(): array
    {
        $versions = [];

        $request = new D2LRequest(d2l: $this, product: '', action: 'GET', route: '');
        $request->route = '/d2l/api/versions/';
        $response = $this->makeHTTPRequest($request);
        if (is_array($response->data)) {
            foreach ($response->data as $product) {
                if (is_object($product) && isset($product->ProductCode, $product->LatestVersion)) {
                    $versions[strval($product->ProductCode)] = $product->LatestVersion;
                }
            }
        }

        if (!isset($versions['ipsis'])) {
            $versions['ipsis'] = 'unstable';
        }

        return $versions;
    }

    /**
     * @param callable(string|null $bookmark): PagedResultSetModel $callAPI
     * @param string $keyField
     * @param string $valueField
     * 
     * @return array<int|string,mixed>
     */
    public function pagedResultAPI(
        callable $callAPI,
        string $keyField = '',
        string $valueField = ''
    ): array {
        $records = array();
        do {
            /** @var PagedResultSetModel $result  */
            $result = $callAPI(bookmark: $result->PagingInfo->Bookmark ?? '');
            foreach ($result->Items as $item) {
                $keyValue = property_exists($item, $keyField) ? (new ReflectionProperty($item, $keyField))->getValue($item) : null;
                $valueValue = property_exists($item, $valueField) ? (new ReflectionProperty($item, $valueField))->getValue($item) : null;

                if ($keyValue !== null) {
                    $records[strval($keyValue)] = $valueValue !== null ? $valueValue : $item;
                } else {
                    $records[] = $valueValue !== null ? $valueValue : $item;
                }
            }
        } while ($result->PagingInfo->HasMoreItems ?? false);

        return $records;
    }

    /**
     * @param callable(string|null $next): ObjectListPageModel $callAPI
     * @param string $keyField
     * @param string $valueField
     * 
     * @return array<int|string,mixed>
     */
    public function objectListAPI(
        callable $callAPI,
        string $keyField = '',
        string $valueField = ''
    ): array {
        $records = array();

        do {
            /** @var ObjectListPageModel $result  */
            $result = $callAPI($result->Next ?? '');

            /** @var string[] */
            $urlParts = parse_url($result->Next ?? '');
            parse_str($urlParts['query'] ?? '', $urlParams);
            $result->Next = $urlParams['bookmark'] ?? null;

            foreach ($result->Objects as $item) {
                $keyValue = property_exists($item, $keyField) ? (new ReflectionProperty($item, $keyField))->getValue($item) : null;
                $valueValue = property_exists($item, $valueField) ? (new ReflectionProperty($item, $valueField))->getValue($item) : null;

                if ($keyValue !== null) {
                    $records[strval($keyValue)] = $valueValue !== null ? $valueValue : $item;
                } else {
                    $records[] = $valueValue !== null ? $valueValue : $item;
                }
            }
        } while ($result->Next !== null);

        return $records;
    }

    /**
     * @param D2LRequest $request
     * 
     * @return D2LResponse
     */
    public function callAPI(D2LRequest $request): D2LResponse
    {
        if ($this->oauthToken !== '') {
            $request->initOAuthParams(oauthToken: $this->oauthToken);
        } else {
            $request->initLegacyAuthParams(
                appId: $this->appID,
                appKey: $this->appKey,
                userId: $this->userID,
                userKey: $this->userKey
            );
        }

        return $this->makeHTTPRequest(request: $request)->verify();
    }

    /**
     * @param D2LRequest $request
     * 
     * @return D2LResponse
     */
    protected function makeHTTPRequest(D2LRequest $request): D2LResponse
    {
        $responseHeaders = [];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request->action);
        curl_setopt($ch, CURLOPT_URL, $request->getURL($this->host));
        if (count($request->headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $request->headers);
        }
        if ($request->data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request->data);
        }
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$responseHeaders) {
            $len = strlen($header);
            $header = explode(':', $header, 2);

            if (count($header) < 2) { // ignore invalid headers
                return $len;
            }

            $name = strtolower(trim($header[0]));
            if (isset($responseHeaders[$name])) {
                if (!is_array($responseHeaders[$name])) {
                    $responseHeaders[$name] = [$responseHeaders[$name]];
                }
                $responseHeaders[$name][] = trim($header[1]);
            } else {
                $responseHeaders[$name] = trim($header[1]);
            }
            return $len;
        });

        if ($request->outputFile === null) {
            $responseBody = curl_exec($ch);
            if (!is_string($responseBody)) {
                $responseBody = '';
            }
        } else {
            $out = fopen($request->outputFile, 'w');
            if ($out === false) {
                throw new D2LException("Unable to open '{$request->outputFile}' for writting");
            }
            curl_setopt($ch, CURLOPT_FILE, $out);
            curl_exec($ch);
            fclose($out);

            // response is bytes written to file
            $responseBody = strval(file_exists($request->outputFile) ? filesize($request->outputFile) : 0);
        }

        $httpCode = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        curl_close($ch);

        if ($request->outputFile === null) {
            $contentType = $responseHeaders["content-type"] ?? '';
            if (is_array($contentType)) {
                $contentType = $responseHeaders["content-type"][0] ?? '';
            }
        } else {
            $contentType = 'file';
        }
        $responseHeaders["content-type"] = $contentType;

        return new D2LResponse(
            request: $request,
            statusCode: $httpCode,
            headers: $responseHeaders,
            data: $responseBody
        );
    }
}
