<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CreditCard;

class CreditCardDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $creditCard = new CreditCard;
        $creditCard->setName('John Doe');
        $creditCard->setNumber('4242424242424242');
        $creditCard->setCvc('123');
        $creditCard->setExpirationMonth('1');
        $creditCard->setExpirationYear('2020');

        $creditCardDTO = $creditCard->getDTOBuilder()
            ->build();

        $this->assertTrue($creditCardDTO instanceof CreditCardDTO);
    }
}
