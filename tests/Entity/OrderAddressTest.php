<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderAddressDTOBuilder;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OrderAddressTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $orderAddress = new OrderAddress;
        $orderAddress->firstName = 'John';
        $orderAddress->lastName = 'Doe';
        $orderAddress->company = 'Acme Co.';
        $orderAddress->address1 = '123 Any St';
        $orderAddress->address2 = 'Ste 3';
        $orderAddress->city = 'Santa Monica';
        $orderAddress->state = 'CA';
        $orderAddress->zip5 = '90401';
        $orderAddress->zip4 = '3274';
        $orderAddress->phone = '555-123-4567';
        $orderAddress->email = 'john@example.com';
        $orderAddress->setCountry('US');
        $orderAddress->setIsResidential(true);

        $this->assertEntityValid($orderAddress);
        $this->assertTrue($orderAddress instanceof OrderAddress);
        $this->assertSame('John Doe', $orderAddress->getFullName());
        $this->assertSame('US', $orderAddress->getCountry());
        $this->assertSame(true, $orderAddress->isResidential());
        $this->assertTrue($orderAddress->getDTOBuilder() instanceof OrderAddressDTOBuilder);
    }

    public function testCreateFromDTO()
    {

    }
}
