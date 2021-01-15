<?php


namespace Matscode\Paystack\Providers;


use Matscode\Paystack\Exceptions\InvalidResourceException;
use Matscode\Paystack\ResourceRegistry;
use Matscode\Paystack\Utility\HTTP\HTTPClient;

/**
 * Class PaystackResourceProvider
 * @package Matscode\Paystack\Providers
 *
 * @property \Matscode\Paystack\Resources\Transaction $transaction
 */
abstract class PaystackResourceProvider
{
    protected $HTTPClient, $callbackUrl = null;

    public function __construct(string $secretKey)
    {
        $this->HTTPClient = new HTTPClient($secretKey);
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
            return new ResourceRegistry::$registry[$resourceName]($this->HTTPClient);
        } else {
            throw new InvalidResourceException('\'' . $resourceName . '\' is not a valid resource in the ResourceRegistry');
        }
    }
}