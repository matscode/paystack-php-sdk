<?php

namespace Matscode\Paystack\Providers;

use Matscode\Paystack\Utility\HTTP\HTTPClient;

abstract class PaystackResourceProvider
{
    protected HTTPClient $HTTPClient;
    protected $callbackUrl = null;

    public function __construct(string $secretKey)
    {
        $this->HTTPClient = new HTTPClient($secretKey);
    }

    public function __get(string $name)
    {
        return new ResourceContainer($this->HTTPClient, [$name]);
    }
}