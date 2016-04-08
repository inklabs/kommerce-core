<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;

class ChargeResponseDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $chargeResponse = new ChargeResponse;

        $chargeResponseDTO = $chargeResponse->getDTOBuilder()
            ->build();

        $this->assertTrue($chargeResponseDTO instanceof ChargeResponseDTO);
    }
}
