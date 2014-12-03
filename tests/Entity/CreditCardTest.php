<?php
namespace inklabs\kommerce\Entity;

class CreditCardTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $creditCard = new CreditCard('4242424242424242', '01', '2020');

        $this->assertEquals('4242424242424242', $creditCard->getNumber());
        $this->assertEquals('01', $creditCard->getExpirationMonth());
        $this->assertEquals('2020', $creditCard->getExpirationYear());
    }
}
