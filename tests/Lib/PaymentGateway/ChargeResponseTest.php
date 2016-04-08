<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\tests\Helper\TestCase\KommerceTestCase;

class ChargeResponseTest extends KommerceTestCase
{
    public function testCreate()
    {
        $chargeResponse = new ChargeResponse;
        $chargeResponse->setExternalId('ch_xxxxxxxxxxxxxx');
        $chargeResponse->setAmount(2000);
        $chargeResponse->setLast4('4242');
        $chargeResponse->setBrand('Visa');
        $chargeResponse->setCurrency('usd');
        $chargeResponse->setDescription('test@example.com');
        $chargeResponse->setCreated(1420656887);

        $this->assertEntityValid($chargeResponse);
        $this->assertSame('ch_xxxxxxxxxxxxxx', $chargeResponse->getExternalId());
        $this->assertSame(2000, $chargeResponse->getAmount());
        $this->assertSame('4242', $chargeResponse->getLast4());
        $this->assertSame('Visa', $chargeResponse->getBrand());
        $this->assertSame(1420656887, $chargeResponse->getCreated());
        $this->assertSame('usd', $chargeResponse->getCurrency());
        $this->assertSame('test@example.com', $chargeResponse->getDescription());
    }

    public function testLoadValidatorMetadata()
    {
        $chargeResponse = new ChargeResponse;

        $chargeResponse->setExternalId(str_pad('x', 256, 'x'));
        $chargeResponse->setAmount(2147483648);
        $chargeResponse->setLast4('xxxx');
        $chargeResponse->setBrand('12345678901234567');
        $chargeResponse->setCurrency('xxxx');
        $chargeResponse->setDescription(str_pad('x', 256, 'x'));
        $chargeResponse->setCreated(-1);

        $errors = $this->getValidationErrors($chargeResponse);

        $this->assertSame(7, sizeof($errors));
        $this->assertSame('externalId', $errors->get(0)->getPropertyPath());
        $this->assertSame('created', $errors->get(1)->getPropertyPath());
        $this->assertSame('last4', $errors->get(2)->getPropertyPath());
        $this->assertSame('brand', $errors->get(3)->getPropertyPath());
        $this->assertSame('amount', $errors->get(4)->getPropertyPath());
        $this->assertSame('currency', $errors->get(5)->getPropertyPath());
        $this->assertSame('description', $errors->get(6)->getPropertyPath());
    }
}
