<?php

namespace Matscode\Paystack\Resources\Miscellaneous;

use GuzzleHttp\Exception\GuzzleException;
use Matscode\Paystack\Resources\BaseResource;
use Matscode\Paystack\Exceptions\JsonException;
use stdClass;

class Card extends BaseResource
{
    protected string $basePath = 'decision/bin';

    /**
     * Get more information about a customer's card by its first 6 characters (BIN).
     * 
     * @link https://paystack.com/docs/api/#miscellaneous-bin
     * 
     * @param string $bin First 6 characters of the card
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function resolveInfo(string $bin): stdClass
    {
        return $this->httpClient->getJson($this->path($bin));
    }
}