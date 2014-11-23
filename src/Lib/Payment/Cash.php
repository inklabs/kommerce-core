<?php
namespace inklabs\kommerce\Lib\Payment;

class Cash extends Payment
{
    public function __construct($amount)
    {
        $this->amount = $amount;
    }
}
