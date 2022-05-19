<?php

namespace Matscode\Paystack;

use Matscode\Paystack\Resources;

class ResourceRegistry
{
    public static array $registry = [
        'transaction' => Resources\Transaction::class,
        'bank' => Resources\Bank::class,
    ];
}
