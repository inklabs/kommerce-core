<?php
namespace inklabs\kommerce\Entity;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $address = new Address;
        $address->setAttention('John Doe');
        $address->setCompany('Acme Co.');
        $address->setAddress1('123 Any St');
        $address->setAddress2('Ste 3');
        $address->setCity('Santa Monica');
        $address->setState('CA');
        $address->setZip5('90401');
        $address->setZip4('3274');
        $address->setLatitude(34.010947);
        $address->setLongitude(-118.490541);

        $this->assertEquals('John Doe', $address->getAttention());
        $this->assertEquals('Acme Co.', $address->getCompany());
        $this->assertEquals('123 Any St', $address->getAddress1());
        $this->assertEquals('Ste 3', $address->getAddress2());
        $this->assertEquals('Santa Monica', $address->getCity());
        $this->assertEquals('CA', $address->getState());
        $this->assertEquals('90401', $address->getZip5());
        $this->assertEquals('3274', $address->getZip4());
        $this->assertEquals(34.010947, $address->getLatitude(), '', 0.000001);
        $this->assertEquals(-118.490541, $address->getLongitude(), '', 0.000001);
    }
}
