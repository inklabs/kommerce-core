<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CreditPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $creditCard = new Entity\CreditCard;
        $creditCard->setName('John Doe');
        $creditCard->setNumber('4242424242424242');
        $creditCard->setCvc('123');
        $creditCard->setExpirationMonth('1');
        $creditCard->setExpirationYear('2020');

        $chargeRequest = new Lib\PaymentGateway\ChargeRequest;
        $chargeRequest->setCreditCard($creditCard);
        $chargeRequest->setAmount(2000);
        $chargeRequest->setCurrency('usd');
        $chargeRequest->setDescription('test@example.com');

        $entityCredit = new Entity\CreditPayment($chargeRequest, new Lib\PaymentGateway\StripeFake);

        $credit = $entityCredit->getView()->export();

        $this->assertTrue($credit instanceof CreditPayment);
        $this->assertTrue($credit->chargeResponse instanceof ChargeResponse);
    }
}
