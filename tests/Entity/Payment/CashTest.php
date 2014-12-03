<?php
namespace inklabs\kommerce\Entity\Payment;

class CashTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $payment = new Cash(100);
        $this->assertEquals(100, $payment->getAmount());
    }
}
