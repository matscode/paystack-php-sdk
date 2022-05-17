<?php


namespace Matscode\Paystack\Utility\HTTP;


use GuzzleHttp\Client;

class HTTPClient extends Client
{

    private string $apiBaseUrl = 'https://api.paystack.co/'; // with trailing slash

    public function __construct(string $secretKey)
    {
        parent::__construct([
            'base_uri' => $this->apiBaseUrl,
            'headers' => [
                'Content-Type'     => 'application/json',
                'Authorization'     => 'Bearer ' . $secretKey,
            ]
        ]);
    }

    public function requestFactory(array $messageComponent)
    {
        // TODO: Justify the need for this function before implementing...
    }
}
