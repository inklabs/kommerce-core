<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Lib\PaymentGateway\Gateway;
use inklabs\kommerce\Lib\PaymentGateway\ChargeRequest;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;

class Credit extends Payment
{
    /* @var ChargeResponse */
    protected $charge;

    public function __construct(ChargeRequest $chargeRequest, Gateway $gateway)
    {
        $this->setCreated();
        $this->amount = $chargeRequest->getAmount();
        $this->setCharge($gateway->getCharge($chargeRequest));
    }

    private function setCharge(ChargeResponse $chargeResponse)
    {
        $this->charge = $chargeResponse;
    }

    /**
     * @return ChargeResponse
     */
    public function getCharge()
    {
        return $this->charge;
    }
}
