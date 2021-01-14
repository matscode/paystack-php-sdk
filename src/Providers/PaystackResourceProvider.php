<?php


namespace Matscode\Paystack\Providers;


use Matscode\Paystack\Exceptions\InvalidResourceException;
use Matscode\Paystack\ResourceRegistry;
use Matscode\Paystack\Utility\HTTP\HTTPClient;

abstract class PaystackResourceProvider
{
    protected $HTTPClient, $callbackUrl = null;

    public function __construct(string $secretKey)
    {
        $this->HTTPClient = new HTTPClient($secretKey);
    }

    public function setCallbackUrl(string $callbackUrl){
        $this->callbackUrl = $callbackUrl;
    }

    /**
     * @param $resourceName
     * @return mixed
     * @throws InvalidResourceException
     * @ignore
     */
    public function __get($resourceName)
    {
        if (array_key_exists($resourceName, ResourceRegistry::$registry)) {
            return new ResourceRegistry::$registry[$resourceName]($this->HTTPClient, $this->callbackUrl);
        } else {
            throw new InvalidResourceException('\'' . $resourceName . '\' is not a valid resource in the ResourceRegistry');
        }
    }
}