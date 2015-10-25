<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CashPaymentTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $payment = new CashPayment(100);

        $this->assertEntityValid($payment);
        $this->assertSame(100, $payment->getAmount());
    }
}
