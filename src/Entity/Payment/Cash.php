<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity as Entity;

class Cash extends Payment
{
    public function __construct($amount)
    {
        $this->setCreated();
        $this->amount = $amount;
    }

    public function getView()
    {
        return new Entity\View\Payment\Cash($this);
    }
}
