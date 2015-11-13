<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

class StripeFake implements GatewayInterface
{
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
        $last4 = substr($card->getNumber(), -4);

        $response = array(
            'id' => 'ch_xxxxxxxxxxxxxx',
            'object' => 'charge',
            'created' => time(),
            'livemode' => false,
            'paid' => true,
            'amount' => $chargeRequest->getAmount(),
            'currency' => $chargeRequest->getCurrency(),
            'refunded' => false,
            'source' => array(
                'id' => 'card_xxxxxxxxxxxxxx',
                'object' => 'card',
                'last4' => $last4,
                'brand' => 'Visa',
                'funding' => 'credit',
                'exp_month' => $card->getExpirationMonth(),
                'exp_year' => $card->getExpirationYear(),
                'fingerprint' => 'xxxxxxxxxxxxxxxx',
                'country' => 'US',
                'name' => null,
                'address_line1' => null,
                'address_line2' => null,
                'address_city' => null,
                'address_state' => null,
                'address_zip' => $card->getZip5(),
                'address_country' => null,
                'cvc_check' => "pass",
                'address_line1_check' => null,
                'address_zip_check' => "pass",
                'dynamic_last4' => null,
                'customer' => null,
                'type' => 'Visa',
            ),
            'captured' => true,
            'balance_transaction' => 'txn_xxxxxxxxxxxxxx',
            'failure_message' => null,
            'failure_code' => null,
            'amount_refunded' => 0,
            'customer' => null,
            'invoice' => null,
            'description' => $chargeRequest->getDescription(),
            'dispute' => null,
            'metadata' => array(),
            'statement_description' => null,
            'fraud_details' => array(
                'stripe_report' => 'unavailable',
                'user_report' => null,
            ),
            'receipt_email' => null,
            'receipt_number' => null,
            'shipping' => null,
        );

        $apiKey = 'sk_xxxxxxxxxxxxxxxxxxxxxxxx';

        return \Stripe\Util\Util::convertToStripeObject($response, $apiKey);
    }
}
