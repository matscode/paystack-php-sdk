<?php

namespace Matscode\Paystack\Resources;

use Matscode\Paystack\Interfaces\ResourceInterface;
use Matscode\Paystack\Utility\HTTP\HTTPClient;

abstract class BaseResource implements ResourceInterface
{
    protected HTTPClient $httpClient;
    protected string $basePath;

    public function __construct(HTTPClient $HTTPClient)
    {
        $this->httpClient = $HTTPClient;

        // Use explicit $basePath if set, otherwise convert PascalCase to snake_case
        if (!isset($this->basePath)) {
            $className = (new \ReflectionClass($this))->getShortName();
            $this->basePath = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
        }
    }

    protected function path(string $endpoint = ''): string
    {
        $base = trim($this->basePath, '/');
        $endpoint = trim($endpoint, '/');

        if ($endpoint === '') {
            return $base . '/';
        }

        return $base . '/' . $endpoint . '/';
    }
}