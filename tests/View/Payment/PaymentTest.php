<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class PaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPayment = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Payment\AbstractPayment');

        $payment = $this->getMockForAbstractClass(
            'inklabs\kommerce\View\Payment\AbstractPayment',
            [$entityPayment]
        )
            ->export();

        $this->assertTrue($payment instanceof Payment\AbstractPayment);
    }
}
