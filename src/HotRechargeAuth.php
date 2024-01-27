<?php

namespace Tinosoft\HotRecharge;

class HotRechargeAuth
{
    public $userName;
    public $userPassword;
    public $reference;

    public function __construct($userName, $userPassword, $reference = null)
    {
        $this->userName     = $userName;
        $this->userPassword = $userPassword;
        $this->reference    = $reference;

        $this->checkReferenceLimit();
    }

    private function checkReferenceLimit()
    {
        if ($this->reference !== null && strlen($this->reference) > 50) {
            throw new ReferenceExceedLimit("reference must not exceed 50 characters");
        }
    }

    private function setReference($reference)
    {
        $this->reference = $reference;
        $this->checkReferenceLimit();
    }

    private function toString()
    {
        return "<HotRechargeAuthConfig: {$this->userName}, {$this->access_password}, {$this->reference}>";
    }
}
