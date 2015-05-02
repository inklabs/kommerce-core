<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class PaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPayment = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Payment\Payment');

        $payment = $this->getMockForAbstractClass(
            'inklabs\kommerce\View\Payment\Payment',
            [$entityPayment]
        )
            ->export();

        $this->assertTrue($payment instanceof Payment\Payment);
    }
}
