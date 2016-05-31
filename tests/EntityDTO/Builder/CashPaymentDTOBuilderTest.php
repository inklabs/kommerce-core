<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\tests\EntityDTO\Builder\AbstractPaymentDTOBuilderTest;

class CashPaymentDTOBuilderTest extends AbstractPaymentDTOBuilderTest
{
    /**
     * @return CashPayment
     */
    protected function getPayment()
    {
        return $this->dummyData->getCashPayment();
    }

    /**
     * @return CashPaymentDTO
     */
    protected function getPaymentDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getCashPaymentDTOBuilder($this->getPayment())
            ->build();
    }

    public function testExtras()
    {
        $payment = $this->getPayment();
        $paymentDTO = $this->getPaymentDTO();

        $this->assertTrue($paymentDTO instanceof CashPaymentDTO);
    }
}
