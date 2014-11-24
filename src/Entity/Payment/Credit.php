<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Lib\PaymentGateway\Gateway;
use inklabs\kommerce\Lib\PaymentGateway\ChargeRequest;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;

class Credit extends Payment
{
    protected $creditCard;

    protected $charge;
    protected $chargeId;
    protected $chargeCreated;
    protected $chargeAmount;
    protected $chargeCurrency;
    protected $chargeFee;
    protected $chargeDescription;

    public function __construct(ChargeRequest $chargeRequest, Gateway $gateway)
    {
        $this->setCreated();
        $this->amount = $chargeRequest->getAmount();
        $this->creditCard = $chargeRequest->getCreditCard();
        $this->setCharge($gateway->getCharge($chargeRequest));
    }

    private function setCharge(ChargeResponse $chargeResponse)
    {
        $this->charge = $chargeResponse;
        $this->chargeId = $chargeResponse->getId();
        $this->chargeCreated = $chargeResponse->getCreated();
        $this->chargeAmount = $chargeResponse->getAmount();
        $this->chargeCurrency = $chargeResponse->getCurrency();
        $this->chargeFee = $chargeResponse->getFee();
        $this->chargeDescription = $chargeResponse->getDescription();
    }

    public function getCharge()
    {
        return $this->charge;
    }
}
