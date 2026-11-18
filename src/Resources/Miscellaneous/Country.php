<?php

namespace Matscode\Paystack\Resources\Miscellaneous;

use GuzzleHttp\Exception\GuzzleException;
use Matscode\Paystack\Resources\BaseResource;
use Matscode\Paystack\Exceptions\JsonException;
use stdClass;

class Country extends BaseResource
{
    /**
     * Gets a list of countries that Paystack currently supports.
     * 
     * @link https://paystack.com/docs/api/#miscellaneous-country
     * 
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function list(): stdClass
    {
        return $this->httpClient->getJson($this->path());
    }
}