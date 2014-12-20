<?php
namespace inklabs\kommerce\Entity\View\Payment;

use inklabs\kommerce\Entity as Entity;

abstract class Payment
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
