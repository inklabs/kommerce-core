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

    public function testLoadValidatorMetadata()
    {
        $chargeResponse = new ChargeResponse;

        $chargeResponse->setId(str_pad('x', 256, 'x'));
        $chargeResponse->setAmount(2147483648);
        $chargeResponse->setLast4('xxxx');
        $chargeResponse->setBrand('12345678901234567');
        $chargeResponse->setCreated(-1);
        $chargeResponse->setCurrency('xxxx');
        $chargeResponse->setFee(2147483648);
        $chargeResponse->setDescription(str_pad('x', 256, 'x'));

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errors = $validator->validate($chargeResponse);

        $this->assertSame(8, sizeof($errors));
        $this->assertSame('id', $errors->get(0)->getPropertyPath());
        $this->assertSame('created', $errors->get(1)->getPropertyPath());
        $this->assertSame('last4', $errors->get(2)->getPropertyPath());
        $this->assertSame('brand', $errors->get(3)->getPropertyPath());
        $this->assertSame('amount', $errors->get(4)->getPropertyPath());
        $this->assertSame('currency', $errors->get(5)->getPropertyPath());
        $this->assertSame('fee', $errors->get(6)->getPropertyPath());
        $this->assertSame('description', $errors->get(7)->getPropertyPath());
    }
}
