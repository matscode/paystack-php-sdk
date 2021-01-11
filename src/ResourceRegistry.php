<?php
namespace Matscode\Paystack;

class ResourceRegistry {
    public static $registry = [
        'transaction' => \Matscode\Paystack\Transaction::class
    ];
}