<?php

namespace Tinosoft\HotRecharge;

class HRAuthConfig
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

    public function set_access_code($userName)
    {
        $this->userName = $userName;
    }

    public function set_access_password($userPassword)
    {
        $this->userPassword = $userPassword;
    }

    public function set_reference($reference)
    {
        $this->reference = $reference;
        $this->checkReferenceLimit();
    }

    public function __toString()
    {
        return "<HotRechargeAuthConfig: {$this->userName}, {$this->access_password}, {$this->reference}>";
    }
}
