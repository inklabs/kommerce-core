<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderAddressDTOBuilder;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class OrderAddressTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $orderAddress = new OrderAddress;

        $this->assertSame(null, $orderAddress->getFirstName());
        $this->assertSame(null, $orderAddress->getLastName());
        $this->assertSame(null, $orderAddress->getCompany());
        $this->assertSame(null, $orderAddress->getAddress1());
        $this->assertSame(null, $orderAddress->getAddress2());
        $this->assertSame(null, $orderAddress->getCity());
        $this->assertSame(null, $orderAddress->getState());
        $this->assertSame(null, $orderAddress->getZip5());
        $this->assertSame(null, $orderAddress->getZip4());
        $this->assertSame(null, $orderAddress->getPhone());
        $this->assertSame(null, $orderAddress->getEmail());
        $this->assertSame(null, $orderAddress->getCountry());
        $this->assertTrue($orderAddress->isResidential());
    }

    public function testCreate()
    {
        $orderAddress = new OrderAddress;
        $orderAddress->setFirstName('John');
        $orderAddress->setLastName('Doe');
        $orderAddress->setCompany('Acme Co.');
        $orderAddress->setAddress1('123 Any St');
        $orderAddress->setAddress2('Ste 3');
        $orderAddress->setCity('Santa Monica');
        $orderAddress->setState('CA');
        $orderAddress->setZip5('90401');
        $orderAddress->setZip4('3274');
        $orderAddress->setPhone('555-123-4567');
        $orderAddress->setEmail('john@example.com');
        $orderAddress->setCountry('US');
        $orderAddress->setIsResidential(false);

        $this->assertEntityValid($orderAddress);
        $this->assertSame('John', $orderAddress->getFirstName());
        $this->assertSame('Doe', $orderAddress->getLastName());
        $this->assertSame('Acme Co.', $orderAddress->getCompany());
        $this->assertSame('123 Any St', $orderAddress->getAddress1());
        $this->assertSame('Ste 3', $orderAddress->getAddress2());
        $this->assertSame('Santa Monica', $orderAddress->getCity());
        $this->assertSame('CA', $orderAddress->getState());
        $this->assertSame('90401', $orderAddress->getZip5());
        $this->assertSame('3274', $orderAddress->getZip4());
        $this->assertSame('555-123-4567', $orderAddress->getPhone());
        $this->assertSame('john@example.com', $orderAddress->getEmail());
        $this->assertSame('US', $orderAddress->getCountry());
        $this->assertFalse($orderAddress->isResidential());
    }
}
