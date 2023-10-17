<?php

namespace Tinosoft\HotRecharge;

require_once 'vendor/autoload.php';
require_once 'HRAuthConfig.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HotRecharge
{
    protected $client;
    private $config;
    private $headers = [];

    public function __construct(
        HRAuthConfig $config,
        bool $use_random_ref = true,
    ) {
        $this->client         = new Client();
        $this->use_random_ref = $use_random_ref;
        $this->config         = $config;
        $this->setupHeaders();
    }

    public function walletBalance()
    {
        try {
            $response = $this->client->request('GET', Constants::BASE_URL . Constants::WALLET_BALANCE, [
                'headers' => $this->headers,
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function userBalance($mobileNumber)
    {
        try {
            $response = $this->client->request('GET', Constants::BASE_URL . Constants::ENDUSER_BALANCE, [
                'headers' => $this->headers,
                'query'   => ['targetmobile' => $mobileNumber]
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargePinless($amount, $mobileNumber)
    {
        try {
            $body     = json_encode(['amount' => $amount, 'targetmobile' => $mobileNumber]);
            $response = $this->client->request('POST', Constants::BASE_URL . Constants:: RECHARGE_PINLESS, [
                'headers' => $this->headers,
                'body'    => $body
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function queryTransaction($ref)
    {
        try {
            $response = $this->client->request('GET', Constants::BASE_URL . Constants::QUERY_TRANSACTION . $ref, [
                'headers' => $this->headers,
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargeData($productcode, $mobileNumber)
    {
        try {
            $body     = json_encode(['productcode' => $productcode, 'targetmobile' => $mobileNumber]);
            $response = $this->client->request('POST', Constants::BASE_URL . Constants::RECHARGE_DATA, [
                'headers' => $this->headers,
                'body'    => $body
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function getDataBundles()
    {
        try {
            $response = $this->client->request('GET', Constants::BASE_URL . Constants::GET_DATA_BUNDLE, [
                'headers' => $this->headers,
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function queryEvd()
    {
        try {
            $response = $this->client->request('GET', Constants::BASE_URL . Constants::QUERY_EVD, [
                'headers' => $this->headers,
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function bulkEvd($brandId, $denomination, $quantity)
    {
        try {
            $body     = json_encode(['BrandID' => $brandId, 'Denomination' => $denomination, 'Quantity' => $quantity]);
            $response = $this->client->request('POST', Constants::BASE_URL . Constants::BULK_EVD, [
                'headers' => $this->headers,
                'body'    => $body
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargeEvd($brandId, $denomination, $quantity, $phoneNumber)
    {
        try {
            $body     = json_encode(
                [
                    'BrandID'      => $brandId,
                    'Denomination' => $denomination,
                    'Quantity'     => $quantity,
                    'TargetNumber' => $phoneNumber
                ]
            );
            $response = $this->client->request('POST', Constants::BASE_URL . Constants::RECHARGE_EVD, [
                'headers' => $this->headers,
                'body'    => $body
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    // ZESA Calls
    public function zesaBalance()
    {
        try {
            $response = $this->client->request('GET', Constants::BASE_URL . Constants::ZESA_BALANCE, [
                'headers' => $this->headers,
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function zesaCustomer($meterNumber)
    {
        $body = json_encode(['MeterNumber' => $meterNumber]);
        try {
            $response = $this->client->request('POST', Constants::BASE_URL . Constants::ZESA_CUSTOMER, [
                'headers' => $this->headers,
                'body'    => $body
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargeZesa($meterNumber, $targetMobile, $amount)
    {
        $body = json_encode(['MeterNumber' => $meterNumber, 'TargetNumber' => $targetMobile, 'Amount' => $amount]);
        try {
            $response = $this->client->request('POST', Constants::BASE_URL . Constants::RECHARGE_ZESA, [
                'headers' => $this->headers,
                'body'    => $body
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    /**
     * @param RequestException|\Exception $e
     *
     * @return string
     */
    public function hrExceptions(RequestException|\Exception $e): string
    {
        if ($e->hasResponse()) {
            $response   = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $body       = $response->getBody()->getContents();

            // Handle the response or error message
            return $body;
        } else {
            // Handle other request-related exceptions
            return "Request Exception: " . $e->getMessage() . "\n";
        }
    }

    private function setupHeaders()
    {
        if ($this->config) {
            if ($this->use_random_ref) {
                $this->headers = [
                    "x-access-code"     => $this->config->userName,
                    "x-access-password" => $this->config->userPassword,
                    "x-agent-reference" => $this->uuidChunkRef(),
                    "content-type"      => Constants::MIME_TYPES,
                    "cache-control"     => "no-cache",
                ];
            } else {
                $this->headers = [
                    "x-access-code"     => $this->config->userName,
                    "x-access-password" => $this->config->userPassword,
                    "x-agent-reference" => $this->config->reference,
                    "content-type"      => Constants::MIME_TYPES,
                    "cache-control"     => "no-cache",
                ];
            }
        }
    }

    private function uuidChunkRef()
    {
        $uuid_ref = uniqid(); // Generating a unique reference using PHP's uniqid() function
        $chunk    = explode("-", $uuid_ref);

        return $chunk[0];
    }

    private function __autoUpdateRef()
    {
        if ($this->use_random_ref) {
            $this->__headers["x-agent-reference"] = $this->uuidChunkRef();
        }
    }

}
