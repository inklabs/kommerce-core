<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\EntityDTO\AbstractPaymentDTO;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

abstract class AbstractPaymentDTOBuilderTest extends EntityDTOBuilderTestCase
{
    /**
     * @return AbstractPayment
     */
    abstract protected function getPayment();

    /**
     * @return AbstractPaymentDTO
     */
    abstract protected function getPaymentDTO();

    public function testBuild()
    {
        $payment = $this->getPayment();
        $paymentDTO = $this->getPaymentDTO();

        $this->assertTrue($paymentDTO instanceof AbstractPaymentDTO);
        $this->assertSame($paymentDTO->amount, $payment->getAmount());
    }
}
