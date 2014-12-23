<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CreditCardTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCreditCard = new Entity\CreditCard('4242424242424242', '01', '2014');
        $creditCard = $entityCreditCard->getView();
        $this->assertTrue($creditCard instanceof CreditCard);
    }
}
