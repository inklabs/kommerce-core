<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class ShipmentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $shipment = new Shipment;
        $shipment->addShipmentTrackingNumber(
            new ShipmentTrackingNumber(
                ShipmentTrackingNumber::CARRIER_UPS,
                '1Z9999999999999999'
            )
        );

        $shipment->addShipmentItem(
            new ShipmentItem(
                new OrderItem,
                1
            )
        );

        $shipment->addShipmentComment(new ShipmentComment('Enjoy your items!'));

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($shipment));
        $this->assertTrue($shipment->getShipmentTrackingNumbers()[0] instanceof ShipmentTrackingNumber);
        $this->assertTrue($shipment->getShipmentItems()[0] instanceof ShipmentItem);
        $this->assertTrue($shipment->getShipmentComments()[0] instanceof ShipmentComment);
    }
}
