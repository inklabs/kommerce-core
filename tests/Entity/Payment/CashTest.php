<?php
namespace inklabs\kommerce\Entity\Payment;

class CashTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $payment = new Cash(100);
        $this->assertSame(100, $payment->getAmount());
    }
}
