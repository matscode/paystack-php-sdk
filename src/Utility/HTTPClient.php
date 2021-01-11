<?php


namespace Matscode\Paystack\Utility;


use GuzzleHttp\Client;

class HTTPClient
{

    private
        $client,
        $apiBaseUrl = 'https://api.paystack.co/', // with trailing slash
        $curl,
        $secretKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->apiBaseUrl
        ]);
    }
}