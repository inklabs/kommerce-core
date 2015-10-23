<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class ShipmentTrackingNumberTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $shipmentTrackingNumber = new ShipmentTrackingNumber(
            ShipmentTrackingNumber::CARRIER_UPS,
            '1Z9999999999999999'
        );

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($shipmentTrackingNumber));
        $this->assertSame(ShipmentTrackingNumber::CARRIER_UPS, $shipmentTrackingNumber->getCarrier());
        $this->assertSame('1Z9999999999999999', $shipmentTrackingNumber->getTrackingNumber());
    }
}
