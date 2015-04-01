<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\Lib\PaymentGateway\ChargeRequest;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;
use inklabs\kommerce\Lib\PaymentGateway\StripeFake;
use Symfony\Component\Validator\Validation;

class CreditTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $creditCard = new CreditCard;
        $creditCard->setName('John Doe');
        $creditCard->setNumber('4242424242424242');
        $creditCard->setCvc('123');
        $creditCard->setExpirationMonth('1');
        $creditCard->setExpirationYear('2020');

        $chargeRequest = new ChargeRequest;
        $chargeRequest->setCreditCard($creditCard);
        $chargeRequest->setAmount(100);
        $chargeRequest->setCurrency('usd');
        $chargeRequest->setDescription('test@example.com');

        $payment = new Credit($chargeRequest, new StripeFake);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($payment));
        $this->assertSame(100, $payment->getAmount());
        $this->assertTrue($payment->getChargeResponse() instanceof ChargeResponse);
    }
}
