<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\ShippingRate;

class ShippingRateDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $shippingRate = new ShippingRate;

        $shippingRateDTO = $shippingRate->getDTOBuilder()
            ->build();

        $this->assertTrue($shippingRateDTO instanceof ShippingRateDTO);
    }
}
