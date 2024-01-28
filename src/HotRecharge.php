<?php

namespace Tinosoft\HotRecharge;

require_once 'vendor/autoload.php';
require_once 'HotRechargeAuth.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HotRecharge
{
    protected $client;
    private $auth;
    private $headers = [];

    public function __construct(
        HotRechargeAuth $hrAuth,
        bool $use_random_ref = true,
    ) {
        $this->client         = new Client();
        $this->use_random_ref = $use_random_ref;
        $this->auth           = $hrAuth;
        $this->setupHeaders();
    }

    public function walletBalance()
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::WALLET_BALANCE,
                [
                    'headers' => $this->headers,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function userBalance($mobileNumber)
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::ENDUSER_BALANCE,
                [
                    'headers' => $this->headers,
                    'query'   => ['targetmobile' => $mobileNumber]
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function walletBalanceUsd()
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::WALLET_BALANCE_USD,
                [
                    'headers' => $this->headers,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargePinless($amount, $mobileNumber)
    {
        try {
            $body     = json_encode(['amount' => $amount, 'targetmobile' => $mobileNumber]);
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::RECHARGE_PINLESS,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function queryTransaction($ref)
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::QUERY_TRANSACTION . $ref,
                [
                    'headers' => $this->headers,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargeData($productcode, $mobileNumber)
    {
        try {
            $body     = json_encode(['productcode' => $productcode, 'targetmobile' => $mobileNumber]);
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::RECHARGE_DATA,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function getDataBundles()
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::GET_DATA_BUNDLE,
                [
                    'headers' => $this->headers,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function queryEvd()
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::QUERY_EVD,
                [
                    'headers' => $this->headers,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function bulkEvd($brandId, $denomination, $quantity)
    {
        try {
            $body     = json_encode(['BrandID' => $brandId, 'Denomination' => $denomination, 'Quantity' => $quantity]);
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::BULK_EVD,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

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
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::RECHARGE_EVD,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    // ZESA Calls
    public function zesaBalance()
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::ZESA_BALANCE,
                [
                    'headers' => $this->headers,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function zesaCustomer($meterNumber)
    {
        $body = json_encode(['MeterNumber' => $meterNumber]);
        try {
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::ZESA_CUSTOMER,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargeZesa($meterNumber, $targetMobile, $amount)
    {
        $body = json_encode(['MeterNumber' => $meterNumber, 'TargetNumber' => $targetMobile, 'Amount' => $amount]);
        try {
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::RECHARGE_ZESA,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function queryZesaTransaction($rechargeId)
    {
        $body = json_encode(['RechargeId' => $rechargeId]);
        try {
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::QUERY_ZESA,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    // TELONE Calls

    public function teloneBalance()
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::QUERY_TELONE_BALANCE,
                [
                    'headers' => $this->headers,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function taloneBulkEvd($productId, $quantity)
    {
        $body = json_encode(['ProductID' => $productId, 'Quantity' => $quantity]);
        try {
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::BULK_TELONE_EVD,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargeTeloneAdsl($productId, $accountNumber, $telNumber = null)
    {
        $body = json_encode(['ProductID' => $productId, 'AccountNumber' => $accountNumber, 'TargetNumber' => $telNumber]
        );
        try {
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::RECHARGE_TELONE_ADSL,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function teloneVerifyAccountNumber($accountNumber)
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::VERIFY_TELONE_ACCOUNT . '/' . $accountNumber,
                [
                    'headers' => $this->headers,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function teloneQueryBalance($accountNumber)
    {
        try {
            $response = $this->client->request(
                'GET',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::QUERY_TELONE_BALANCE . '/' . $accountNumber,
                [
                    'headers' => $this->headers,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function payTeloneBill($accountNumber, $amount, $telNumber = null)
    {
        $body = json_encode(['AccountNumber' => $accountNumber, 'Amount' => $amount, 'TargetNumber' => $telNumber]
        );
        try {
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::PAY_TELONE_BILL,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargeTeloneVoip($accountNumber, $amount, $telNumber = null)
    {
        $body = json_encode(['AccountNumber' => $accountNumber, 'Amount' => $amount, 'TargetNumber' => $telNumber]
        );
        try {
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::RECHARGE_TELONE_VOIP,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $this->hrExceptions($e);
        }
    }

    public function rechargeUsdEvdPin($accountNumber, $denomination, $quantity, $telNumber)
    {
        $body = json_encode(
            [
                'BrandID'      => $accountNumber,
                'Denomination' => $denomination,
                "Quantity"     => $quantity,
                'TargetNumber' => $telNumber
            ]
        );
        try {
            $response = $this->client->request(
                'POST',
                HotRechargeConstants::BASE_URL . HotRechargeConstants::RECHARGE_USD_EVD_PIN,
                [
                    'headers' => $this->headers,
                    'body'    => $body
                ]
            );

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
            $response = $e->getResponse();

            return $response->getBody()->getContents();
        } else {
            // Handle other request-related exceptions
            return "Request Exception: " . $e->getMessage() . "\n";
        }
    }

    private function setupHeaders()
    {
        if ($this->auth) {
            if ($this->use_random_ref) {
                $this->headers = [
                    "x-access-code"     => $this->auth->userName,
                    "x-access-password" => $this->auth->userPassword,
                    "x-agent-reference" => $this->uuidChunkRef(),
                    "content-type"      => HotRechargeConstants::MIME_TYPES,
                    "cache-control"     => "no-cache",
                ];
            } else {
                $this->headers = [
                    "x-access-code"     => $this->auth->userName,
                    "x-access-password" => $this->auth->userPassword,
                    "x-agent-reference" => $this->auth->reference,
                    "content-type"      => HotRechargeConstants::MIME_TYPES,
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

    private function autoUpdateRef()
    {
        if ($this->use_random_ref) {
            $this->__headers["x-agent-reference"] = $this->uuidChunkRef();
        }
    }

}
