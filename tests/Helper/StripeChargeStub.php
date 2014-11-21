<?php

namespace inklabs\kommerce\Helper;

class StripeChargeStub
{
    public static function create()
    {
        $response = array(
            'id' => 'ch_xxxxxxxxxxxxxx',
            'object' => 'charge',
            'created' => time(),
            'livemode' => false,
            'paid' => true,
            'amount' => 2000,
            'currency' => 'usd',
            'refunded' => false,
            'card' => array(
                'id' => 'card_xxxxxxxxxxxxxx',
                'object' => 'card',
                'last4' => '4242',
                'brand' => 'Visa',
                'funding' => 'credit',
                'exp_month' => 5,
                'exp_year' => 2025,
                'fingerprint' => 'xxxxxxxxxxxxxxxx',
                'country' => 'US',
                'name' => null,
                'address_line1' => null,
                'address_line2' => null,
                'address_city' => null,
                'address_state' => null,
                'address_zip' => null,
                'address_country' => null,
                'cvc_check' => null,
                'address_line1_check' => null,
                'address_zip_check' => null,
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
            'description' => null,
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
            'fee' => 88,
            'fee_details' => array(
                0 => array(
                    'amount' => 88,
                    'currency' => 'usd',
                    'type' => 'stripe_fee',
                    'description' => 'Stripe processing fees',
                    'application' => null,
                ),
            ),
        );

        $apiKey = 'sk_xxxxxxxxxxxxxxxxxxxxxxxx';

        return \Stripe_Util::convertToStripeObject($response, $apiKey);
    }
}
