<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CashPaymentDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $cashPayment = $this->dummyData->getCashPayment();

        $cashPaymentDTO = $cashPayment->getDTOBuilder()
            ->build();

        $this->assertTrue($cashPaymentDTO instanceof CashPaymentDTO);
    }
}
