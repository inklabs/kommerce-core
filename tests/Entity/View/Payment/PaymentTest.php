<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class PaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPayment = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Payment\Payment');

        $payment = $this->getMockForAbstractClass(
            'inklabs\kommerce\Entity\View\Payment\Payment',
            [$entityPayment]
        )
            ->export();

        $this->assertTrue($payment instanceof Payment\Payment);
    }
}
