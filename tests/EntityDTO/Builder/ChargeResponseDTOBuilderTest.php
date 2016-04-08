<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ChargeResponseDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $chargeResponse = $this->dummyData->getChargeResponse();

        $chargeResponseDTO = $chargeResponse->getDTOBuilder()
            ->build();

        $this->assertTrue($chargeResponseDTO instanceof ChargeResponseDTO);
    }
}
