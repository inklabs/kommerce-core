<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

interface GatewayInterface
{
    /**
     * @param ChargeRequest $chargeRequest
     * @return ChargeResponse
     */
    public function getCharge(ChargeRequest $chargeRequest);
}
