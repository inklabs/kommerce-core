<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

class FakePaymentGateway implements PaymentGatewayInterface
{
    public function getCharge(ChargeRequest $chargeRequest): ChargeResponse
    {
        $card = $chargeRequest->getCreditCard();
        $last4 = substr($card->getNumber(), -4);

        $chargeResponse = new ChargeResponse();
        $chargeResponse->setExternalId('ch_xxxxxxxxxxxxxx');
        $chargeResponse->setAmount($chargeRequest->getAmount());
        $chargeResponse->setLast4($last4);
        $chargeResponse->setBrand('Visa');
        $chargeResponse->setCurrency($chargeRequest->getCurrency());
        $chargeResponse->setDescription($chargeRequest->getDescription());
        $chargeResponse->setCreated(time());

        return $chargeResponse;
    }
}
