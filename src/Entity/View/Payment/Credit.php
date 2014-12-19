<?php
namespace inklabs\kommerce\Entity\View\Payment;

use inklabs\kommerce\Entity as Entity;

class Credit extends Payment
{
    public $charge;

    public function __construct(Entity\Payment\Credit $credit)
    {
        parent::__construct($credit);

        $this->charge = $credit->getCharge()->getView()
            ->export();

        return $this;
    }
}
