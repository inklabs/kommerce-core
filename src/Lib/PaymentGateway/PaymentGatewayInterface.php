<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

interface PaymentGatewayInterface
{
    public function getCharge(ChargeRequest $chargeRequest): ChargeResponse;
}
