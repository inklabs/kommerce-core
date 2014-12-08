<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

class GatewayTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getMock('inklabs\kommerce\Lib\PaymentGateway\Gateway');
        $this->assertInstanceOf('inklabs\kommerce\Lib\PaymentGateway\Gateway', $mock);
    }
}
