<?php

namespace Matscode\Paystack\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Matscode\Paystack\Exceptions\JsonException;
use Matscode\Paystack\Interfaces\ResourceInterface;
use Matscode\Paystack\Traits\ResourcePath;
use Matscode\Paystack\Utility\Helpers;
use Matscode\Paystack\Utility\HTTP\HTTPClient;
use stdClass;

class Bank implements ResourceInterface
{
    use ResourcePath;

    protected $httpClient;

    /**
     * @throws \Exception
     */
    public function __construct(HTTPClient $HTTPClient)
    {
        $this->setBasePath('bank');

        $this->httpClient = $HTTPClient;
    }

    /**
     * List available bank information
     *
     * @link https://paystack.com/docs/api/#miscellaneous-bank
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function list(): stdClass
    {
        return Helpers::JSONStringToObj($this->httpClient->get($this->makePath())->getBody());
    }

    /**
     * Resolve account number to get account name for valid account verification
     *
     * @link https://paystack.com/docs/api/#verification-resolve-account
     *
     * @param $bank_code
     * @param $account_number
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function resolve($bank_code, $account_number): StdClass
    {
        return Helpers::JSONStringToObj($this->httpClient->get($this->makePath('/resolve'), [
            'query' => [
                'bank_code' => $bank_code,
                'account_number' => $account_number,
            ]
        ])->getBody());
    }
}
