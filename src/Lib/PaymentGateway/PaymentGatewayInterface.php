<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

interface PaymentGatewayInterface
{
    /**
     * @param ChargeRequest $chargeRequest
     * @return ChargeResponse
     */
    public function getCharge(ChargeRequest $chargeRequest);
}
