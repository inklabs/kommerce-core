<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class WarehouseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $address = new Address;
        $address->setAttention('John Doe');
        $address->setAddress1('123 Any St');
        $address->setCity('Santa Monica');
        $address->setState('CA');
        $address->setZip5('90401');
        $address->setPoint(new Point);

        $warehouse = new Warehouse;
        $warehouse->setName('Store Headquarters');
        $warehouse->setAddress($address);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($warehouse));
        $this->assertSame('Store Headquarters', $warehouse->getName());
        $this->assertTrue($warehouse->getAddress() instanceof Address);
        $this->assertTrue($warehouse->getView() instanceof View\Warehouse);
    }
}
