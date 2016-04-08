<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ChargeResponseDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $chargeResponse = $this->dummyData->getChargeResponse();

        $chargeResponseDTO = $chargeResponse->getDTOBuilder()
            ->build();

        $this->assertTrue($chargeResponseDTO instanceof ChargeResponseDTO);
    }
}
