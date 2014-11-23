<?php
namespace inklabs\kommerce\Lib\Payment;

use inklabs\kommerce\Lib\Payment\Gateway\Gateway;
use inklabs\kommerce\Lib\Payment\Gateway\ChargeRequest;
use inklabs\kommerce\Lib\Payment\Gateway\ChargeResponse;

class Credit extends Payment
{
    protected $creditCard;
    protected $charge;

    public function __construct(ChargeRequest $chargeRequest, Gateway $gateway)
    {
        $this->amount = $chargeRequest->getAmount();
        $this->creditCard = $chargeRequest->getCreditCard();
        $this->charge = $gateway->getCharge($chargeRequest);
    }

    public function getCharge()
    {
        return $this->charge;
    }
}
