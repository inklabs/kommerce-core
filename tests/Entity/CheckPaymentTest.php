<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CheckPaymentTest extends EntityTestCase
{
    public function testCreate()
    {
        $memo = 'Order #00098765';
        $checkDate = new DateTime('4/13/2016');
        $checkNumber = '0001234';
        $amount = 100;

        $payment = new CheckPayment(
            $amount,
            $checkNumber,
            $checkDate,
            $memo
        );

        $this->assertEntityValid($payment);
        $this->assertSame($amount, $payment->getAmount());
        $this->assertSame($checkNumber, $payment->getCheckNumber());
        $this->assertSame($checkDate, $payment->getCheckDate());
        $this->assertSame($memo, $payment->getMemo());
    }
}
