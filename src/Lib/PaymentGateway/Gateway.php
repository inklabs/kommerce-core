<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

interface Gateway
{
    /* @returns ChargeResponse */
    public function getCharge(ChargeRequest $chargeRequest);
}
