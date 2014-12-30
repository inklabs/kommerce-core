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
        $address->setLatitude(34.010947);
        $address->setLongitude(-118.490541);

        $warehouse = new Warehouse;
        $warehouse->setId(1);
        $warehouse->setName('Store Headquarters');
        $warehouse->setAddress($address);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($warehouse));
        $this->assertSame(1, $warehouse->getId());
        $this->assertSame('Store Headquarters', $warehouse->getName());
        $this->assertTrue($warehouse->getAddress() instanceof Address);
        $this->assertTrue($warehouse->getView() instanceof View\Warehouse);
    }
}
