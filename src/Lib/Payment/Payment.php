<?php
namespace inklabs\kommerce\Lib\Payment;

abstract class Payment
{
    protected $amount;

    public function getAmount()
    {
        return $this->amount;
    }
}
