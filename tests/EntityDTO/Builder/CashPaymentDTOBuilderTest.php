<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CashPaymentDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $cashPayment = $this->dummyData->getCashPayment();

        $cashPaymentDTO = $cashPayment->getDTOBuilder()
            ->build();

        $this->assertTrue($cashPaymentDTO instanceof CashPaymentDTO);
    }
}
