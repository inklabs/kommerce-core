<?php
namespace inklabs\kommerce\View\Payment;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View\ViewInterface;

abstract class Payment implements ViewInterface
{
    public $id;
    public $amount;
    public $created;
    public $updated;

    public function __construct(Entity\Payment\Payment $payment)
    {
        $this->payment = $payment;

        $this->id      = $payment->getId();
        $this->amount  = $payment->getAmount();
        $this->created = $payment->getCreated();
        $this->updated = $payment->getUpdated();
    }

    public function export()
    {
        unset($this->payment);
        return $this;
    }
}
