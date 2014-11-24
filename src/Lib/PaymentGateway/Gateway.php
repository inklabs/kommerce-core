<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

interface Gateway
{
    public function getCharge(ChargeRequest $chargeRequest);
}
