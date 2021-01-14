<?php
/**
 * Class for Transaction Resource
 *
 * @package        Paystack\Resources\Transaction
 * @author         Michael Akanji <matscode@gmail.com>
 *
 */

namespace Matscode\Paystack\Resources;

use Matscode\Paystack\Interfaces\ResourceInterface;
use Matscode\Paystack\Traits\ResourcePath;
use Matscode\Paystack\Utility\HTTP\HTTPClient;
use Matscode\Paystack\Utility\Text;

class Transaction implements ResourceInterface
{
    use ResourcePath;

    private
        $data = [],
        $resp =
        [
            'verify' => null,
            'initialize' => null
        ];

    private
        $httpClient;

    public function __construct(HTTPClient $HTTPClient, $callbackUrl = null)
    {
        $this->setBasePath('/transaction');
        $this->httpClient = $HTTPClient;
    }

    /**
     * This method must be called to request for payment. which return an initial transaction obj
     *
     * @param array $data
     * @param bool $rawResponse
     *
     * @return mixed|\stdClass
     * @throws \GuzzleHttp\Exception\ClientException
     *
     */
    public function initialize(array $data = [], $rawResponse = false)
    {
        $this->setPath('/initialize');

        $this->data = array_merge($this->data, $data);

        $this->data['reference'] = 'REF-' . ($this->data['reference'] ?? Text::uniqueRef());

        $this->resp['initialize'] =
            $this->httpClient
                ->post($this->getPath(), ['json' => $this->data])->getBody();

        if ($rawResponse) {
            $response =
                $this->resp['initialize'];
        } else {
            // Initialize a new Obj to save Striped response
            $response = new \stdClass();
            if (isset($this->resp['initialize']->data) &&
                is_object($this->resp['initialize']->data)
            ) {
                $response->authorizationUrl = $this->resp['initialize']->data->authorization_url;
                $response->reference = $this->resp['initialize']->data->reference;
            } else {
                // return the raw response
                $response =
                    $this->resp['initialize'];
            }
        }

        return $response;
    }

    /**
     * Is used to Check if a transaction is successful and return the transaction object data
     *
     * @param null $reference
     *
     * @return mixed
     * @throws \Exception
     *
     */
    public function verify($reference = null)
    {
        // try to guess reference if not set
        if (is_null($reference)) {
            // guess reference
            if (isset($_GET['reference'])) {
                $reference = $_GET['reference'];
            } else {
                // return false
                return false;
            }
        }

        $this->resp['verify'] =
            $this
                ->setAction('verify', [$reference])
                ->sendRequest([], 'GET');

        return $this->resp['verify'];
    }

    /**
     * Like verify(), but it only checks to see if a transactions is successful returning boolean
     *
     * @param null $reference
     *
     * @return bool
     * @throws \Exception
     */
    public function isSuccessful($reference = null): bool
    {
        // get verify response
        $response = $this->verify($reference);

        // Initialize as !isSuccessful
        $isSuccessful = false;

        // check if transaction is successful
        if (isset($response->data) && is_object($response->data) &&
            $response->status == true &&
            $response->data->status == 'success'
        ) {
            $isSuccessful = true;
        }

        return $isSuccessful;
    }

    /**
     * Compares the amount paid by customer to the amount passed into it
     *
     * @param $amountExpected
     *
     * @return bool
     */
    public function amountEquals($amountExpected): bool
    {
        // $this->verify(); // call verify() or isSuccessful() before calling this method
        $transactionResponse = $this->resp['verify'];
        if (is_object($transactionResponse)) {
            return
                ((int)$transactionResponse->data->amount === $amountExpected);
        }

        return false;
    }

    /**
     * @param null $reference
     *
     * @return string|null
     * @throws \Exception
     */
    public function getAuthorizationCode($reference = null)
    {
        $authorizationCode = null;
        // get verify response
        if ($this->isSuccessful($reference)) {
            $response = $this->verify($reference);
            $authorizationCode = $response->data->authorization->authorization_code;
        }

        return $authorizationCode;
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
    public function setReference(string $reference)
    {
        $this->data['reference'] = $reference;

        return $this;
    }

    /**
     * @param bool $afterInitialize
     *
     * @return null
     *
     */
    public function getReference($afterInitialize = false)
    {
        if ($afterInitialize) {
            $reference = $this->response->data->reference;
        } else {
            $reference = $this->data['reference'];
        }

        return $reference;
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
        $this->data['callback_url'] = $callbackUrl;

        return $this;
    }

}