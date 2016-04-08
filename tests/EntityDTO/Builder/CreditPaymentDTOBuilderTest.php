<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CreditPaymentDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $creditPayment = $this->dummyData->getCreditPayment();

        $creditPaymentDTO = $creditPayment->getDTOBuilder()
            ->build();

        $this->assertTrue($creditPaymentDTO instanceof CreditPaymentDTO);
        $this->assertTrue($creditPaymentDTO->chargeResponse instanceof ChargeResponseDTO);
    }
}
