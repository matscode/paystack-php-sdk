<?php

namespace Matscode\Paystack\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Matscode\Paystack\Exceptions\InvalidArgumentException;
use Matscode\Paystack\Exceptions\JsonException;
use stdClass;

class Subscription extends BaseResource
{
    /**
     * Create a subscription on Paystack.
     * @link https://paystack.com/docs/api/#subscription-create
     * 
     * @param array $data
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function create(array $data): stdClass
    {
        if (!($data['customer'] ?? null) || !($data['plan'] ?? null)) {
            throw new InvalidArgumentException('(customer) and (plan) are required to create a subscription!');
        }

        return $this->httpClient->postJson($this->path(), [
            'json' => $data
        ]);
    }

    /**
     * List all subscriptions.
     * @link https://paystack.com/docs/api/#subscription-list
     * 
     * @param int $numberOfRecords
     * @param int $page
     * @param array $otherOptions
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function list(int $numberOfRecords = 50, int $page = 1, array $otherOptions = []): stdClass
    {
        $query = http_build_query($otherOptions + [
            'perPage' => $numberOfRecords,
            'page' => $page
        ]);

        return $this->httpClient->getJson($this->path() . '?' . $query);
    }

    /**
     * Fetch subscription details by code or ID.
     * @link https://paystack.com/docs/api/#subscription-fetch
     * 
     * @param string $codeOrId
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function fetch(string $codeOrId): stdClass
    {
        return $this->httpClient->getJson($this->path($codeOrId));
    }

    /**
     * Disable a subscription.
     * @link https://paystack.com/docs/api/#subscription-disable
     * 
     * @param array $data
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function disable(array $data): stdClass
    {
        if (!($data['code'] ?? null) || !($data['token'] ?? null)) {
            throw new InvalidArgumentException('(code) and (token) are required to disable a subscription!');
        }

        return $this->httpClient->postJson($this->path('disable'), [
            'json' => $data
        ]);
    }

    /**
     * Enable a subscription.
     * @link https://paystack.com/docs/api/#subscription-enable
     * 
     * @param array $data
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function enable(array $data): stdClass
    {
        if (!($data['code'] ?? null) || !($data['token'] ?? null)) {
            throw new InvalidArgumentException('(code) and (token) are required to enable a subscription!');
        }

        return $this->httpClient->postJson($this->path('enable'), [
            'json' => $data
        ]);
    }
}