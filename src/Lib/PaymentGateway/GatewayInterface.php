<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

interface GatewayInterface
{
    /* @return ChargeResponse */
    public function getCharge(ChargeRequest $chargeRequest);
}
