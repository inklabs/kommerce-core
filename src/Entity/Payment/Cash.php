<?php
namespace inklabs\kommerce\Entity\Payment;

class Cash extends Payment
{
    public function __construct($amount)
    {
        $this->setCreated();
        $this->amount = $amount;
    }
}
