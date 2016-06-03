<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\tests\EntityDTO\Builder\AbstractPaymentDTOBuilderTest;

class CreditPaymentDTOBuilderTest extends AbstractPaymentDTOBuilderTest
{
    /**
     * @return CreditPayment
     */
    protected function getPayment()
    {
        return $this->dummyData->getCreditPayment();
    }

    /**
     * @return CreditPaymentDTO
     */
    protected function getPaymentDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getPaymentDTOBuilder($this->getPayment())
            ->build();
    }

    public function testExtras()
    {
        $payment = $this->getPayment();
        $paymentDTO = $this->getPaymentDTO();

        $this->assertTrue($paymentDTO instanceof CreditPaymentDTO);
        $this->assertTrue($paymentDTO->chargeResponse instanceof ChargeResponseDTO);
    }
}
