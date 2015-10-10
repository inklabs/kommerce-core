<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

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
        $address->setPoint(new Point(34.052234, -118.243685));

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($address));
        $this->assertSame('John Doe', $address->getAttention());
        $this->assertSame('Acme Co.', $address->getCompany());
        $this->assertSame('123 Any St', $address->getAddress1());
        $this->assertSame('Ste 3', $address->getAddress2());
        $this->assertSame('Santa Monica', $address->getCity());
        $this->assertSame('CA', $address->getState());
        $this->assertSame('90401', $address->getZip5());
        $this->assertSame('3274', $address->getZip4());
        $this->assertTrue($address->getPoint() instanceof Point);
    }
}
