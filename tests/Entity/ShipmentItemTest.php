<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class ShipmentItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $shipmentItem = new ShipmentItem(new OrderItem, 1);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($shipmentItem));
        $this->assertTrue($shipmentItem->getOrderItem() instanceof OrderItem);
        $this->assertSame(1, $shipmentItem->getQuantityToShip());
    }
}
