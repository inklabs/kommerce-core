<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\ShipmentRate;

class ShipmentRateDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $shipmentRate = new ShipmentRate(new Money(1, 'USD'));

        $shipmentRateDTO = $shipmentRate->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentRateDTO instanceof ShipmentRateDTO);
    }
}
