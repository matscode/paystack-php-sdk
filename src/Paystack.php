<?php


namespace Matscode\Paystack;

use Matscode\Paystack\Interfaces\PaymentProvider;

class Paystack implements PaymentProvider
{
    public function __construct(string $secretKey)
    {
        echo $secretKey;
    }

    public function __get($propertyName)
    {
        // TODO: Implement __get() method and get the related resource
        echo 'this is property was tried to be access: ' . $propertyName;
    }
}