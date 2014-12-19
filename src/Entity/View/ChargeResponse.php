<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class ChargeResponse
{
    public $id;
    public $created;
    public $amount;
    public $last4;
    public $currency;
    public $fee;
    public $description;

    public function __construct(Lib\PaymentGateway\ChargeResponse $chargeResponse)
    {
        $this->chargeResponse = $chargeResponse;

        $this->id          = $chargeResponse->getId();
        $this->created     = $chargeResponse->getCreated();
        $this->amount      = $chargeResponse->getAmount();
        $this->last4       = $chargeResponse->getLast4();
        $this->currency    = $chargeResponse->getCurrency();
        $this->fee         = $chargeResponse->getFee();
        $this->description = $chargeResponse->getDescription();

        return $this;
    }

    public function export()
    {
        unset($this->chargeResponse);
        return $this;
    }
}
