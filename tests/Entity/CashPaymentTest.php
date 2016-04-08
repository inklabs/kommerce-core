<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CashPaymentTest extends EntityTestCase
{
    public function testCreate()
    {
        $payment = new CashPayment(100);

        $this->assertEntityValid($payment);
        $this->assertSame(100, $payment->getAmount());
    }
}
