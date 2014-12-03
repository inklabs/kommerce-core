<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

class ChargeResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $chargeResponse = new ChargeResponse;

        $chargeResponse->setId('ch_xxxxxxxxxxxxxx');
        $chargeResponse->setAmount(2000);
        $chargeResponse->setLast4('4242');
        $chargeResponse->setCreated(1);
        $chargeResponse->setCurrency('usd');
        $chargeResponse->setFee(88);
        $chargeResponse->setDescription('test@example.com');

        $this->assertEquals('ch_xxxxxxxxxxxxxx', $chargeResponse->getId());
        $this->assertEquals(2000, $chargeResponse->getAmount());
        $this->assertEquals('4242', $chargeResponse->getLast4());
        $this->assertEquals(1, $chargeResponse->getCreated());
        $this->assertEquals('usd', $chargeResponse->getCurrency());
        $this->assertEquals(88, $chargeResponse->getFee());
        $this->assertEquals('test@example.com', $chargeResponse->getDescription());
    }
}
