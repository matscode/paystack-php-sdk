<?php

namespace Matscode\Paystack\Resources\Miscellaneous;

use GuzzleHttp\Exception\GuzzleException;
use Matscode\Paystack\Resources\BaseResource;
use Matscode\Paystack\Exceptions\InvalidArgumentException;
use Matscode\Paystack\Exceptions\JsonException;
use stdClass;

class Bank extends BaseResource
{
    /**
     * List available bank information with optional filters.
     * 
     * @link https://paystack.com/docs/api/#miscellaneous-bank
     * 
     * @param array $options Query parameters
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function list(array $options = []): stdClass
    {
        $queryString = !empty($options) ? '?' . http_build_query($options) : '';

        return $this->httpClient->getJson($this->path() . $queryString);
    }

    /**
     * Resolve account number to get account name for valid account verification
     *
     * @link https://paystack.com/docs/api/#verification-resolve-account
     * 
     * @param string $bank_code
     * @param string $account_number
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function resolve(string $bank_code, string $account_number): stdClass
    {
        return $this->httpClient->getJson($this->path('resolve'), [
            'query' => [
                'bank_code' => $bank_code,
                'account_number' => $account_number,
            ]
        ]);
    }

    /**
     * Confirm the authenticity of a customer's account number before sending money
     * 
     * @link https://paystack.com/docs/api/#verification-validate-account
     * 
     * @param array $data
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function validate(array $data): stdClass
    {
        $required = ['bank_code', 'country_code', 'account_number', 'account_name', 'account_type', 'document_type'];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                throw new InvalidArgumentException("($field) is required to validate an account!");
            }
        }

        return $this->httpClient->postJson($this->path('validate'), [
            'json' => $data
        ]);
    }
}