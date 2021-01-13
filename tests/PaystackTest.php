<?php

use Matscode\Paystack\Paystack;
use PHPUnit\Framework\TestCase;

class PaystackTest extends TestCase
{
    public function testMagicResourceIsResolved()
    {
        $paystack = new Paystack('sk_');

        $this->assertInstanceOf(\Matscode\Paystack\Resources\Transaction::class, $paystack->transaction);
    }
}