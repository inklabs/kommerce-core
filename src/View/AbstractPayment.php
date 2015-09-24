<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

abstract class AbstractPayment implements ViewInterface
{
    public $id;
    public $amount;
    public $created;
    public $updated;

    public function __construct(Entity\AbstractPayment $payment)
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
