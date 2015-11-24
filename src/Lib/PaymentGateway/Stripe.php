<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

class Stripe implements PaymentGatewayInterface
{
    public function __construct($apiKey)
    {
        \Stripe\Stripe::setApiKey($apiKey);
    }

    public function getCharge(ChargeRequest $chargeRequest)
    {
        $stripeCharge = $this->createCharge($chargeRequest);

        $chargeResponse = new ChargeResponse;
        $chargeResponse->setExternalId($stripeCharge['id']);
        $chargeResponse->setAmount($stripeCharge['amount']);
        $chargeResponse->setLast4($stripeCharge['source']['last4']);
        $chargeResponse->setBrand($stripeCharge['source']['brand']);
        $chargeResponse->setCurrency($stripeCharge['currency']);
        $chargeResponse->setDescription($stripeCharge['description']);
        $chargeResponse->setCreated($stripeCharge['created']);

        return $chargeResponse;
    }

    private function createCharge(ChargeRequest $chargeRequest)
    {
        $card = $chargeRequest->getCreditCard();

        return \Stripe\Charge::create([
            'amount' => $chargeRequest->getAmount(),
            'currency' => $chargeRequest->getCurrency(),
            'card' => [
                'name' => $card->getName(),
                'address_zip' => $card->getZip5(),
                'number' => $card->getNumber(),
                'cvc' => $card->getCvc(),
                'exp_month' => $card->getExpirationMonth(),
                'exp_year' => $card->getExpirationYear(),
            ],
            'description' => $chargeRequest->getDescription(),
        ]);
    }
}
