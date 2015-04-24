<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class CreditCardTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCreditCard = new Entity\CreditCard;
        $entityCreditCard->setName('John Doe');
        $entityCreditCard->setNumber('4242424242424242');
        $entityCreditCard->setCvc('123');
        $entityCreditCard->setExpirationMonth('1');
        $entityCreditCard->setExpirationYear('2020');

        $creditCard = $entityCreditCard->getView()
            ->export();

        $this->assertTrue($creditCard instanceof CreditCard);
    }
}
