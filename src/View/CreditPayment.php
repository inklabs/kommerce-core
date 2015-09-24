<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class CreditPayment extends AbstractPayment
{
    /** @var ChargeResponse */
    public $chargeResponse;

    public function __construct(Entity\CreditPayment $credit)
    {
        parent::__construct($credit);

        $this->chargeResponse = $credit->getChargeResponse()->getView();

        return $this;
    }
}
