<?php
/**
 * Class for Transaction Resource
 *
 * @package        Paystack\Resources\Transaction
 * @author         Michael Akanji <matscode@gmail.com>
 *
 */

namespace Matscode\Paystack\Resources;

use Matscode\Paystack\Exceptions\InvalidArgumentException;
use Matscode\Paystack\Interfaces\ResourceInterface;
use Matscode\Paystack\Traits\ResourcePath;
use Matscode\Paystack\Utility\Helpers;
use Matscode\Paystack\Utility\HTTP\HTTPClient;
use Matscode\Paystack\Utility\Text;

class Transaction implements ResourceInterface
{
    use ResourcePath;

    protected $httpClient, $callbackUrl, $data;

    public function __construct(HTTPClient $HTTPClient)
    {
        $this->setBasePath('transaction');
        $this->setReference('REF-' . ($this->data['reference'] ?? Text::uniqueStr()));

        $this->httpClient = $HTTPClient;
    }

    /**
     * This method must be called to request for payment. which return an initial transaction obj
     *
     * @link https://paystack.com/docs/api/#transaction-initialize
     *
     * @param array $data
     * @return mixed|\stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function initialize(array $data = []): \stdClass
    {
        $data = array_merge($this->data, $data);

        // check required properties
        if (!($data['email'] ?? null)
            || !(($data['amount'] ?? null)
                || ($data['plan'] ?? null))) {
            throw new InvalidArgumentException('(email) and (amount | plan) are required!');
        }

        $data['callback_url'] = $data['callback_url'] ?? $this->callbackUrl;

        $this->data = []; // empty the bag

        return Helpers::responseToObj($this->httpClient->post($this->makePath('initialize'), [
            'json' => $data
        ]));
    }

    /**
     * Is used to Check if a transaction is successful and return the transaction object data
     *
     * @link https://paystack.com/docs/api/#transaction-verify
     *
     * @param string $referenceCode
     *
     * @return \StdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verify(string $referenceCode): \StdClass
    {
        return Helpers::responseToObj($this->httpClient->get($this->makePath('verify/' . $referenceCode)));
    }

    /**
     * Like verify(), but it only checks to see if a transactions is successful returning boolean
     *
     * @param string $reference
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isSuccessful(string $reference): bool
    {
        $response = $this->verify($reference);

        $isSuccessful = false;

        // check if transaction is successful
        if (isset($response->data)
            && is_object($response->data)
            && $response->status == true
            && $response->data->status == 'success'
        ) {
            $isSuccessful = true;
        }

        return $isSuccessful;
    }

    /**
     * Add metadata to the request data
     *
     * Method can be called chained more than once. Last call with repeated property overwrites the former
     *
     * @param array $metadata
     * @return $this
     */
    public function addMetadata(array $metadata = []): Transaction
    {
        $this->data['metadata'] = array_merge($this->data['metadata'] ?? [], $metadata);

        return $this;
    }

    /**
     * Ignore setting amount when setting plan and vice versa. Plan takes precedence
     *
     * @param string $plan
     * @return $this
     */
    public function setPlan(string $plan): Transaction
    {
        // set amount to 0 to Invalid amount error when setting a plan
        $this->data['amount'] = 0;
        $this->data['plan'] = $plan;

        return $this;
    }

    /**
     * @param $email
     *
     * @return $this
     */
    public function setEmail(string $email): Transaction
    {
        // setting the email
        $this->data['email'] = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

    /**
     * Set transaction amount in kobo(NGN) or pesewas(GHS)
     *
     * NOTE: Setting plan overwrites your defined amount
     *
     * @param int $amount
     *
     * @return $this
     */
    public function setAmount(int $amount): Transaction
    {
        $this->data['amount'] = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): ?int
    {
        return $this->data['amount'] ?? null;
    }

    /**
     * Sets the transaction reference code/id
     *
     * @param string $reference
     * @return Transaction
     */
    public function setReference(string $reference): Transaction
    {
        $this->data['reference'] = $reference;

        return $this;
    }

    /**
     * Returns the transaction code/id used
     *
     * @param bool $afterInitialize
     *
     * @return null
     *
     */
    public function getReference($afterInitialize = false)
    {
        return $this->data['reference'];
    }

    /**
     * To set callback URL, can be used to override callback URL set on paystack dashboard
     *
     * @param string $callbackUrl
     *
     * @return $this
     */
    public function setCallbackUrl(string $callbackUrl): Transaction
    {
        $this->callbackUrl = $callbackUrl;

        return $this;
    }

    /**
     * Get the list of all transactions
     *
     * @link https://paystack.com/docs/api/#transaction-list
     *
     * @param int $numberOfRecords number of record per page
     * @param int $page page number
     * @param array $otherOptions
     * @return \StdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list($numberOfRecords = 50, $page = 1, $otherOptions = []): \StdClass
    {
        return Helpers::responseToObj($this->httpClient->get($this->makePath() . '?' . http_build_query($otherOptions + [
                    'perPage' => $numberOfRecords,
                    'page' => $page
                ])));
    }

}