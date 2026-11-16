<?php

namespace Matscode\Paystack\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Matscode\Paystack\Exceptions\InvalidArgumentException;
use Matscode\Paystack\Exceptions\JsonException;
use stdClass;

class Plan extends BaseResource
{
    /**
     * Create a subscription plan.
     * @link https://paystack.com/docs/api/#plan-create
     * 
     * @param array $data
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function create(array $data): stdClass
    {
        if (!($data['name'] ?? null) || !($data['amount'] ?? null) || !($data['interval'] ?? null)) {
            throw new InvalidArgumentException('(name), (amount), and (interval) are required to create a plan!');
        }

        return $this->httpClient->postJson($this->path(), [
            'json' => $data
        ]);
    }

    /**
     * List all plans.
     * @link https://paystack.com/docs/api/#plan-list
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
     * Fetch a plan by code or ID.
     * @link https://paystack.com/docs/api/#plan-fetch
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
     * Update a plan.
     * @link https://paystack.com/docs/api/#plan-update
     * 
     * @param string $codeOrId
     * @param array $data
     * @return stdClass
     * @throws GuzzleException
     * @throws JsonException
     */
    public function update(string $codeOrId, array $data): stdClass
    {
        return $this->httpClient->putJson($this->path($codeOrId), [
            'json' => $data
        ]);
    }
}