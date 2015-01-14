<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class CreditCardTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $creditCard = new CreditCard('4242424242424242', 1, 2020);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($creditCard));
        $this->assertSame('4242424242424242', $creditCard->getNumber());
        $this->assertSame('01', $creditCard->getExpirationMonth());
        $this->assertSame('2020', $creditCard->getExpirationYear());
        $this->assertTrue($creditCard->getView() instanceof View\CreditCard);
    }
}
