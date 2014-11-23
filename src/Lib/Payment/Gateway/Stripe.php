<?php
namespace inklabs\kommerce\Lib\Payment\Gateway;

use inklabs\kommerce\Lib\Payment;

class Stripe implements Gateway
{
    public function __construct($apiKey)
    {
        \Stripe::setApiKey($apiKey);
    }

    public function getCharge(ChargeRequest $chargeRequest)
    {
        $stripeCharge = $this->createCharge($chargeRequest);

        $chargeResponse = new ChargeResponse;
        $chargeResponse->setId($stripeCharge['id']);
        $chargeResponse->setAmount($stripeCharge['amount']);
        $chargeResponse->setCreated($stripeCharge['created']);
        $chargeResponse->setCurrency($stripeCharge['currency']);
        $chargeResponse->setFee($stripeCharge['fee']);

        return $chargeResponse;
    }

    private function createCharge(ChargeRequest $chargeRequest)
    {
        $card = $chargeRequest->getCreditCard();

        return \Stripe_Charge::create(array(
            'amount' => $chargeRequest->getAmount(),
            'currency' => $chargeRequest->getCurrency(),
            'card' => [
                'number' => $card->getNumber(),
                'exp_month' => $card->getExpirationMonth(),
                'exp_year' => $card->getExpirationYear(),
            ],
            'description' => $chargeRequest->getDescription(),
        ));
    }
}
