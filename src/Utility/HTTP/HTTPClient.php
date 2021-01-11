<?php


namespace Matscode\Paystack\Utility\HTTP;


use GuzzleHttp\Client;

class HTTPClient extends Client
{

    private $apiBaseUrl = 'https://api.paystack.co/'; // with trailing slash

    public function __construct(string $secretKey)
    {
        parent::__construct([
            'base_uri' => $this->apiBaseUrl,
            'headers' => [
                // 'Accept'     => 'application/json',
                'Authentication'     => 'Bearer ' . $secretKey,
            ]
        ]);
    }
}