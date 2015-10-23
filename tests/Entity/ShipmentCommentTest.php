<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class ShipmentCommentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $shipmentComment = new ShipmentComment('Enjoy your items!');

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($shipmentComment));
        $this->assertSame('Enjoy your items!', $shipmentComment->getComment());
    }
}
