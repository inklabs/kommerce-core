<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\CreditCard;
use Symfony\Component\Validator\Validation;

class ChargeRequestTest extends \PHPUnit_Framework_TestCase
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
        $chargeRequest->setAmount(2000);
        $chargeRequest->setCurrency('usd');
        $chargeRequest->setDescription('test@example.com');

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($chargeRequest));
        $this->assertSame(2000, $chargeRequest->getAmount());
        $this->assertSame('usd', $chargeRequest->getCurrency());
        $this->assertSame('test@example.com', $chargeRequest->getDescription());
        $this->assertTrue($chargeRequest->getCreditCard() instanceof CreditCard);
    }
}
