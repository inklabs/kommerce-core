<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\CreditCard;

class StripeFakeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCharge()
    {
        $creditCard = new CreditCard;
        $creditCard->setName('John Doe');
        $creditCard->setZip5('90210');
        $creditCard->setNumber('4242424242424242');
        $creditCard->setCvc('123');
        $creditCard->setExpirationMonth('1');
        $creditCard->setExpirationYear('2020');

        $chargeRequest = new ChargeRequest;
        $chargeRequest->setCreditCard($creditCard);
        $chargeRequest->setAmount(2000);
        $chargeRequest->setCurrency('usd');
        $chargeRequest->setDescription('test@example.com');

        $stripe = new StripeFake;
        $charge = $stripe->getCharge($chargeRequest);

        $this->assertSame(2000, $charge->getAmount());
        $this->assertSame(88, $charge->getFee());
        $this->assertSame('usd', $charge->getCurrency());
        $this->assertSame('test@example.com', $charge->getDescription());
        $this->assertSame('ch_xxxxxxxxxxxxxx', $charge->getExternalId());
        $this->assertSame('4242', $charge->getLast4());
        $this->assertTrue($charge->getCreated() > 0);
    }
}
