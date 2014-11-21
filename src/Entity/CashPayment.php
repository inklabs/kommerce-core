<?php
namespace inklabs\kommerce\Entity;

class CashPayment extends Payment
{
    protected $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }
}
