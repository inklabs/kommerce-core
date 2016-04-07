<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CreditPaymentTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $chargeResponse = $this->dummyData->getChargeResponse();
        $payment = new CreditPayment($chargeResponse);

        $this->assertEntityValid($payment);
        $this->assertSame($chargeResponse, $payment->getChargeResponse());
    }
}
