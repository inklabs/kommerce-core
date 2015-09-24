<?php
namespace inklabs\kommerce\View;

class AbstractPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPayment = $this->getMockForAbstractClass('inklabs\kommerce\Entity\AbstractPayment');

        $payment = $this->getMockForAbstractClass(
            'inklabs\kommerce\View\AbstractPayment',
            [$entityPayment]
        )->export();

        $this->assertTrue($payment instanceof AbstractPayment);
    }
}
