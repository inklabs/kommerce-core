<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CreditCardTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $creditCard = new CreditCard;

        $this->assertSame(null, $creditCard->getName());
        $this->assertSame(null, $creditCard->getNumber());
        $this->assertSame(null, $creditCard->getCvc());
        $this->assertSame(null, $creditCard->getExpirationMonth());
        $this->assertSame(null, $creditCard->getExpirationYear());
    }

    public function testCreate()
    {
        $creditCard = new CreditCard;
        $creditCard->setName('John Doe');
        $creditCard->setZip5('90210');
        $creditCard->setNumber('4242424242424242');
        $creditCard->setCvc('123');
        $creditCard->setExpirationMonth('1');
        $creditCard->setExpirationYear('2020');

        $this->assertEntityValid($creditCard);
        $this->assertSame('John Doe', $creditCard->getName());
        $this->assertSame('4242424242424242', $creditCard->getNumber());
        $this->assertSame('123', $creditCard->getCvc());
        $this->assertSame('01', $creditCard->getExpirationMonth());
        $this->assertSame('2020', $creditCard->getExpirationYear());
    }
}
