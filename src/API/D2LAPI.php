<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\API;

use GAState\Tools\D2L\{
    D2L,
    D2LRequest,
    D2LResponse,
    Model\API\PagedResultSetModel,
    Model\API\ObjectListPageModel
};

/**
 * @package GAState\Tools\D2L\API
 * @access protected
 */
abstract class D2LAPI
{
    /**
     * @param D2L $d2l
     */
    public function __construct(protected D2L $d2l)
    {
    }

    /**
     * @param string $product
     * @param string $action
     * @param string $route
     * @param array<int|string,mixed> $params
     * @param string|array<mixed>|object|null $data
     * @param array<string>|array<string|string> $headers
     * @param string|null $outputFile
     * 
     * @return D2LResponse
     */
    protected function callAPI(
        string $product,
        string $action,
        string $route,
        array $params = [],
        string|array|object|null $data = null,
        array $headers = [],
        ?string $outputFile = null
    ): D2LResponse {
        return $this->d2l->callAPI(request: new D2LRequest(
            d2l: $this->d2l,
            product: $product,
            action: $action,
            route: $route,
            params: $params,
            data: $data,
            headers: $headers,
            outputFile: $outputFile
        ));
    }

    /**
     * @param callable(string|null $bookmark): PagedResultSetModel $callAPI
     * @param string $keyField
     * @param string $valueField
     * 
     * @return array<int|string,mixed>
     */
    protected function pagedResultAPI(
        callable $callAPI,
        string $keyField = '',
        string $valueField = ''
    ): array {
        return $this->d2l->pagedResultAPI(
            callAPI: $callAPI,
            keyField: $keyField,
            valueField: $valueField
        );
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
        return $this->d2l->objectListAPI(
            callAPI: $callAPI,
            keyField: $keyField,
            valueField: $valueField
        );
    }
}
