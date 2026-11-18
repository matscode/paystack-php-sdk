<?php

namespace Matscode\Paystack\Providers;

use Matscode\Paystack\Resources\BaseResource;
use Matscode\Paystack\Utility\HTTP\HTTPClient;

class ResourceContainer
{
    protected HTTPClient $httpClient;
    protected array $segments;

    public function __construct(HTTPClient $httpClient, array $segments)
    {
        $this->httpClient = $httpClient;
        $this->segments = $segments;
    }

    public function __get(string $name)
    {
        $newSegments = array_merge($this->segments, [$name]);
        
        // Build PascalCase class name from segments (e.g. customer -> billing -> card becomes Customer\Billing\Card)
        $studlySegments = array_map('ucfirst', $newSegments);
        $class = 'Matscode\\Paystack\\Resources\\' . implode('\\', $studlySegments);

        // If a concrete BaseResource exists at this depth, instantiate it
        if (class_exists($class)) {
            $reflection = new \ReflectionClass($class);
            if ($reflection->isInstantiable() && is_subclass_of($class, BaseResource::class)) {
                return new $class($this->httpClient);
            }
        }

        // Otherwise, continue nesting deeper
        return new self($this->httpClient, $newSegments);
    }
}