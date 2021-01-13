<?php

use Matscode\Paystack\Paystack;
use PHPUnit\Framework\TestCase;

class PaystackTest extends TestCase
{
    public function test_can_output_my_name()
    {
        $paystack = new Paystack('sk_');

        $this->assertEquals('Paystack', 'Paystack');
    }
}