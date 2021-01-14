<?php
/**
 * @ignore
 */
namespace Matscode\Paystack;

class ResourceRegistry {
    public static $registry = [
        'transaction' => \Matscode\Paystack\Resources\Transaction::class
    ];
}