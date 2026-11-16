<?php

namespace Matscode\Paystack\Utility\HTTP;

use GuzzleHttp\Client;
use Matscode\Paystack\Utility\Helpers;
use stdClass;

class HTTPClient extends Client
{
    private string $apiBaseUrl = 'https://api.paystack.co/';

    public function __construct(string $secretKey)
    {
        parent::__construct([
            'base_uri' => $this->apiBaseUrl,
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $secretKey,
            ]
        ]);
    }

    public function postJson(string $uri, array $options = []): stdClass
    {
        $response = parent::post($uri, $options);
        return Helpers::JSONStringToObj($response->getBody());
    }

    public function getJson(string $uri, array $options = []): stdClass
    {
        $response = parent::get($uri, $options);
        return Helpers::JSONStringToObj($response->getBody());
    }

    public function putJson(string $uri, array $options = []): stdClass
    {
        $response = parent::put($uri, $options);
        return Helpers::JSONStringToObj($response->getBody());
    }
}