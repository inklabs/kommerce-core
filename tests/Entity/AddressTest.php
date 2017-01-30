<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class AddressTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $address = new Address;

        $this->assertSame(null, $address->getAttention());
        $this->assertSame(null, $address->getCompany());
        $this->assertSame(null, $address->getAddress1());
        $this->assertSame(null, $address->getAddress2());
        $this->assertSame(null, $address->getCity());
        $this->assertSame(null, $address->getState());
        $this->assertSame(null, $address->getZip5());
        $this->assertSame(null, $address->getZip4());

        $point = $address->getPoint();
        $this->assertFloatEquals(0.0, $point->getLatitude());
        $this->assertFloatEquals(0.0, $point->getLongitude());
    }

    public function testCreate()
    {
        $point = $this->dummyData->getPoint();

        $address = new Address;
        $address->setAttention('John Doe');
        $address->setCompany('Acme Co.');
        $address->setAddress1('123 Any St');
        $address->setAddress2('Ste 3');
        $address->setCity('Santa Monica');
        $address->setState('CA');
        $address->setZip5('90401');
        $address->setZip4('3274');
        $address->setPoint($point);

        $this->assertEntityValid($address);
        $this->assertSame('John Doe', $address->getAttention());
        $this->assertSame('Acme Co.', $address->getCompany());
        $this->assertSame('123 Any St', $address->getAddress1());
        $this->assertSame('Ste 3', $address->getAddress2());
        $this->assertSame('Santa Monica', $address->getCity());
        $this->assertSame('CA', $address->getState());
        $this->assertSame('90401', $address->getZip5());
        $this->assertSame('3274', $address->getZip4());
        $this->assertSame($point, $address->getPoint());
    }
}
