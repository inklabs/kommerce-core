<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity as Entity;

class StripeStubTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCharge()
    {
        $chargeRequest = new ChargeRequest(
            new Entity\CreditCard('4242424242424242', 5, 2015),
            2000,
            'usd',
            'test@example.com'
        );

        $stripe = new StripeStub;
        $charge = $stripe->getCharge($chargeRequest);

        $this->assertEquals(2000, $charge->getAmount());
        $this->assertEquals(88, $charge->getFee());
        $this->assertEquals('usd', $charge->getCurrency());
        $this->assertEquals('test@example.com', $charge->getDescription());
        $this->assertEquals('ch_xxxxxxxxxxxxxx', $charge->getId());
        $this->assertEquals('4242', $charge->getLast4());
        $this->assertTrue($charge->getCreated() > 0);
    }
}
