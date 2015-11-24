<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CreditPaymentTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $chargeResponse = new ChargeResponse;
        $chargeResponse->setExternalId('ch_xxxxxxxxxxxxxx');
        $chargeResponse->setAmount(2000);
        $chargeResponse->setLast4('4242');
        $chargeResponse->setBrand('Visa');
        $chargeResponse->setCurrency('usd');
        $chargeResponse->setDescription('test@example.com');
        $chargeResponse->setCreated(1420656887);

        $payment = new CreditPayment($chargeResponse);

        $this->assertEntityValid($payment);
        $this->assertSame(2000, $payment->getAmount());
        $this->assertTrue($payment->getChargeResponse() instanceof ChargeResponse);
    }
}
