<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class OrderAddressTest extends \PHPUnit_Framework_TestCase
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

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($orderAddress));
        $this->assertTrue($orderAddress instanceof OrderAddress);
    }
}
