<?php


namespace Matscode\Paystack\Interfaces;


use Matscode\Paystack\Utility\HTTP\HTTPClient;

interface ResourceInterface
{
    public function __construct(HTTPClient $HTTPClient);
}