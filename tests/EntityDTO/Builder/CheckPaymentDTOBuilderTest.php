<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;
use inklabs\kommerce\Entity\CheckPayment;
use inklabs\kommerce\tests\EntityDTO\Builder\AbstractPaymentDTOBuilderTest;

class CheckPaymentDTOBuilderTest extends AbstractPaymentDTOBuilderTest
{
    /**
     * @return CheckPayment
     */
    protected function getPayment()
    {
        return $this->dummyData->getCheckPayment();
    }

    /**
     * @return CheckPaymentDTO
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

        $this->assertTrue($paymentDTO instanceof CheckPaymentDTO);
        $this->assertTrue($paymentDTO->checkDate instanceof DateTime);
    }
}
