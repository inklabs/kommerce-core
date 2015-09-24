<?php
namespace inklabs\kommerce\View\Payment;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View\ChargeResponse;

class Credit extends AbstractPayment
{
    /** @var ChargeResponse */
    public $chargeResponse;

    public function __construct(Entity\Payment\Credit $credit)
    {
        parent::__construct($credit);

        $this->chargeResponse = $credit->getChargeResponse()->getView();

        return $this;
    }
}
