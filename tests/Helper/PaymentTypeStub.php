<?php
namespace inklabs\kommerce\tests\Helper;

use inklabs\kommerce\Entity\Payment\Payment;

class PaymentTypeStub extends Payment
{
    public function __construct($amount)
    {
        $this->setCreated();
        $this->amount = $amount;
    }
}
