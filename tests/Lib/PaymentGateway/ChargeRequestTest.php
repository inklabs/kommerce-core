<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity as Entity;

class ChargeRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $chargeRequest = new ChargeRequest(
            new Entity\CreditCard('4242424242424242', 5, 2015),
            2000,
            'usd',
            'test@example.com'
        );

        $this->assertEquals(2000, $chargeRequest->getAmount());
        $this->assertEquals('usd', $chargeRequest->getCurrency());
        $this->assertEquals('test@example.com', $chargeRequest->getDescription());
        $this->assertInstanceOf('inklabs\kommerce\Entity\CreditCard', $chargeRequest->getCreditCard());
    }
}
