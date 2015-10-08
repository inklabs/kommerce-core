<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use Symfony\Component\Validator\Validation;

class CreditPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $creditCard = new CreditCard;
        $creditCard->setName('John Doe');
        $creditCard->setNumber('4242424242424242');
        $creditCard->setCvc('123');
        $creditCard->setExpirationMonth('1');
        $creditCard->setExpirationYear('2020');

        $chargeRequest = new Lib\PaymentGateway\ChargeRequest;
        $chargeRequest->setCreditCard($creditCard);
        $chargeRequest->setAmount(100);
        $chargeRequest->setCurrency('usd');
        $chargeRequest->setDescription('test@example.com');

        $payment = new CreditPayment($chargeRequest, new Lib\PaymentGateway\StripeFake);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($payment));
        $this->assertSame(100, $payment->getAmount());
        $this->assertTrue($payment->getChargeResponse() instanceof Lib\PaymentGateway\ChargeResponse);
        $this->assertTrue($payment->getView() instanceof View\CreditPayment);
    }
}
