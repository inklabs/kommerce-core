<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use Symfony\Component\Validator\Validation;

class ChargeResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $chargeResponse = new ChargeResponse;

        $chargeResponse->setId('ch_xxxxxxxxxxxxxx');
        $chargeResponse->setAmount(2000);
        $chargeResponse->setLast4('4242');
        $chargeResponse->setBrand('Visa');
        $chargeResponse->setCreated(1420656887);
        $chargeResponse->setCurrency('usd');
        $chargeResponse->setFee(88);
        $chargeResponse->setDescription('test@example.com');

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($chargeResponse));
        $this->assertSame('ch_xxxxxxxxxxxxxx', $chargeResponse->getId());
        $this->assertSame(2000, $chargeResponse->getAmount());
        $this->assertSame('4242', $chargeResponse->getLast4());
        $this->assertSame('Visa', $chargeResponse->getBrand());
        $this->assertSame(1420656887, $chargeResponse->getCreated());
        $this->assertSame('usd', $chargeResponse->getCurrency());
        $this->assertSame(88, $chargeResponse->getFee());
        $this->assertSame('test@example.com', $chargeResponse->getDescription());
    }
}
