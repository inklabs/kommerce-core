<?php
namespace inklabs\kommerce\Lib\Payment\Gateway;

use inklabs\kommerce\Lib\Payment\CreditCard;

class ChargeRequest
{
    protected $creditCard;
    protected $amount;
    protected $currency;
    protected $description;

    public function __construct(CreditCard $creditCard, $amount, $currency, $description)
    {
        $this->creditCard = $creditCard;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCreditCard()
    {
        return $this->creditCard;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
