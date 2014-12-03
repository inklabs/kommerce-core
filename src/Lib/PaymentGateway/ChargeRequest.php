<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\CreditCard;

class ChargeRequest
{
    protected $amount;
    protected $currency;
    protected $description;

    /* @var CreditCard */
    protected $creditCard;

    public function __construct(CreditCard $creditCard, $amount, $currency, $description)
    {
        $this->creditCard = $creditCard;
        $this->amount = (int) $amount;
        $this->currency = $currency;
        $this->description = $description;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return CreditCard
     */
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
