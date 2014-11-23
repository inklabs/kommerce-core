<?php
namespace inklabs\kommerce\Lib\Payment\Gateway;

interface Gateway
{
    public function getCharge(ChargeRequest $chargeRequest);
}
