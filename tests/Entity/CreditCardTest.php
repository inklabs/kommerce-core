<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class CreditCardTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $creditCard = new CreditCard;
        $creditCard->setName('John Doe');
        $creditCard->setNumber('4242424242424242');
        $creditCard->setCvc('123');
        $creditCard->setExpirationMonth('1');
        $creditCard->setExpirationYear('2020');

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($creditCard));
        $this->assertSame('John Doe', $creditCard->getName());
        $this->assertSame('4242424242424242', $creditCard->getNumber());
        $this->assertSame('123', $creditCard->getCvc());
        $this->assertSame('01', $creditCard->getExpirationMonth());
        $this->assertSame('2020', $creditCard->getExpirationYear());
        $this->assertTrue($creditCard->getView() instanceof View\CreditCard);
    }
}
