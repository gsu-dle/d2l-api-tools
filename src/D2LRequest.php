<?php

declare(strict_types=1);

namespace GAState\Tools\D2L;

/**
 * @package GAState\Tools\D2L
 * @access public
 */
class D2LRequest
{
    /**
     * @var string $product
     */
    public string $product;

    /**
     * @var float|string $version
     */
    public string $version;

    /**
     * @var string $action
     */
    public string $action;

    /**
     * @var string $route
     */
    public string $route;

    /**
     * @var array<string,int|string|null> $params
     */
    public array $params;

    /**
     * @var array<string> $headers
     */
    public array $headers;

    /**
     * @var string|null $data
     */
    public ?string $data;

    /**
     * @var string|null $outputFile
     */
    public ?string $outputFile;

    /**
     * @param string $product
     * @param string $action
     * @param string $route
     * @param array<int|string,mixed> $params
     * @param string|array<mixed>|object|null $data
     * @param array<string>|array<string|string> $headers
     * @param string|null $outputFile
     */
    public function __construct(
        D2L $d2l,
        string $product,
        string $action,
        string $route,
        array $params = [],
        string|array|object|null $data = null,
        array $headers = [],
        ?string $outputFile = null
    ) {
        $this->product = $product;
        $this->version = $d2l->versions[$product] ?? '1.0'; // TODO: should probably throw an error instead of default val
        $this->action = $action;
        $this->outputFile = $outputFile;

        $this->initRoute(route: $route);
        $this->initParams(params: $params);
        $this->initHeaders(headers: $headers);
        $this->initData(data: $data);
    }

    /**
     * @param string $route
     * 
     * @return void
     */
    protected function initRoute(string $route): void
    {
        if (substr($route, 0, 1) === '/') $route = substr($route, 1);
        $this->route = "/d2l/api/{$this->product}/{$this->version}/{$route}";
    }

    /**
     * @param array<int|string,mixed> $params
     * 
     * @return void
     */
    protected function initParams(array &$params): void
    {
        $this->params = [];
        foreach ($params as $name => $value) {
            $this->params[strval($name)] = $value !== null ? strval($value) : null;
        }
    }

    /**
     * @param array<string>|array<string,string> $headers
     * 
     * @return void
     */
    protected function initHeaders(array &$headers): void
    {
        $this->headers = [];
        foreach ($headers as $name => $value) {
            if (strval($name) != intval($name)) {
                $value = $name . ': ' . $value;
            }
            $this->headers[] = strval($value);
        }
    }

    /**
     * @param string|array<mixed>|object|null $data
     * 
     * @return void
     */
    protected function initData(string|array|object|null $data): void
    {
        if (is_array($data) || is_object($data)) {
            $data = json_encode($data);
            if ($data === false) {
                $data = null;
            }
        }
        $this->data = $data;
    }

    /**
     * @param string $oauthToken
     * 
     * @return void
     */
    public function initOAuthParams(string $oauthToken): void
    {
        $this->headers[] = "Authorization: Bearer {$oauthToken}";
    }

    /**
     * @param string $appId
     * @param string $appKey
     * @param string $userId
     * @param string $userKey
     * 
     * @return void
     */
    public function initLegacyAuthParams(
        string $appId,
        string $appKey,
        string $userId,
        string $userKey
    ): void {
        $timestamp = time();
        $userSignature = strtoupper($this->action) . "&" . urldecode(strtolower($this->route)) . "&" . $timestamp;
        $this->params["x_a"] = $appId;
        $this->params["x_b"] = $userId;
        $this->params["x_c"] = $this->base64hash(key: $appKey, data: $userSignature);
        $this->params["x_d"] = $this->base64hash(key: $userKey, data: $userSignature);
        $this->params["x_t"] = intval($timestamp);
    }

    /**
     * @param string $host
     * 
     * @return string
     */
    public function getURL(string $host): string
    {
        return $host . $this->route . (count($this->params) > 0 ? '?' . http_build_query($this->params, '', null, PHP_QUERY_RFC3986) : '');
    }

    /**
     * @param string $key
     * @param string $data
     * 
     * @return string
     */
    protected function base64hash(string $key, string $data): string
    {
        $hash = base64_encode(hash_hmac("sha256", utf8_encode($data), utf8_encode($key), true));
        foreach (array("=" => "", "+" => "-", "/" => "_") as $search => $replace) {
            $hash = str_replace($search, $replace, $hash);
        }
        return $hash;
    }
}
