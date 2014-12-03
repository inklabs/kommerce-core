<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\Lib\PaymentGateway\ChargeRequest;
use inklabs\kommerce\Lib\PaymentGateway\StripeStub;

class CreditTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $chargeRequest = new ChargeRequest(
            new CreditCard('4242424242424242', '01', '2014'),
            100,
            'usd',
            'test@example.com'
        );
        $payment = new Credit($chargeRequest, new StripeStub);
        $this->assertEquals(100, $payment->getAmount());
        $this->assertInstanceOf('inklabs\kommerce\Lib\PaymentGateway\ChargeResponse', $payment->getCharge());
    }
}
