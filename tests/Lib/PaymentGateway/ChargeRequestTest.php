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

        $this->assertSame(2000, $chargeRequest->getAmount());
        $this->assertSame('usd', $chargeRequest->getCurrency());
        $this->assertSame('test@example.com', $chargeRequest->getDescription());
        $this->assertTrue($chargeRequest->getCreditCard() instanceof Entity\CreditCard);
    }
}
