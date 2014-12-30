<?php
namespace inklabs\kommerce\Entity;

class CreditCardTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $creditCard = new CreditCard('4242424242424242', '01', '2020');

        $this->assertSame('4242424242424242', $creditCard->getNumber());
        $this->assertSame('01', $creditCard->getExpirationMonth());
        $this->assertSame('2020', $creditCard->getExpirationYear());
        $this->assertTrue($creditCard->getView() instanceof View\CreditCard);
    }
}
