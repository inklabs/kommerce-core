<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

interface Gateway
{
    /* @return ChargeResponse */
    public function getCharge(ChargeRequest $chargeRequest);
}
