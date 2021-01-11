<?php
/**
 * Class for Transaction Resource
 *
 * @package        Paystack SDK
 * @category       Source
 * @author         Michael Akanji <matscode@gmail.com>
 * @date           2020-1-11
 *
 */

namespace Matscode\Paystack\Resources;


use Matscode\Paystack\Interfaces\ResourceInterface;
use Matscode\Paystack\Utility\HTTP\HTTPClient;
use Matscode\Paystack\Utility\Text;

class Transaction implements ResourceInterface
{
    public
        $data = [],
        $amount = 0,
        $email = null,
        $reference = null,
        $resp =
        [
            'verify' => null,
            'initialize' => null
        ];

    private
        $httpClient,
        $basePath = '',
        $path = '',
        $_callbackUrl = null;

    public function __construct(HTTPClient $HTTPClient, $callbackUrl = null)
    {
        $this->httpClient = $HTTPClient;
    }

    /**
     * This method must be called to request for payment. which return an initial transaction obj
     *
     * @param array $data
     * @param bool $rawResponse
     *
     * @return mixed|\stdClass
     */
    public function initialize(array $data = [], $rawResponse = false)
    {
        $this->data += $data;

        $this->data['reference'] = $this->data['reference'] ?? Text::uniqueRef();

        $this->resp['initialize'] =
            $this->httpClient
                ->post('/initialize', $data);


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
     * Is used to Check if a transaction is successful and return the transaction object datd
     *
     * @param null $reference
     *
     * @return mixed
     * @throws \Exception
     * @todo Use session to keep reference temporary per transaction To enhance Transaction reference guessing.
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
     */
    public function isSuccessful($reference = null)
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
    public function amountEquals($amountExpected)
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
    public function setEmail($email)
    {
        // setting the email
        $this->email = $email;

        return $this;
    }

    public function getEmail($email)
    {
        // setting the email
        $this->email = $email;
    }

    /**
     * @param int $amount
     *
     * @return $this
     * @todo Allow to set kobo using '.' syntax
     */
    public function setAmount($amount)
    {
        // setting amount in naira //TODO: Allow to set kobo using '.' syntax
        $this->amount = ($amount * 100);

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the transaction reference code/id
     *
     * @param null $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
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
            $reference = $this->reference;
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
    public function setCallbackUrl($callbackUrl)
    {
        $this->_callbackUrl = $callbackUrl;

        return $this;
    }

}