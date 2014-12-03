<?php
/**
 * Created by PhpStorm.
 * User: pdt256
 * Date: 12/3/14
 * Time: 12:29 AM
 */

namespace inklabs\kommerce\Lib\PaymentGateway;

class GatewayTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getMock('inklabs\kommerce\Lib\PaymentGateway\Gateway');
        $this->assertInstanceOf('inklabs\kommerce\Lib\PaymentGateway\Gateway', $mock);
    }
}
