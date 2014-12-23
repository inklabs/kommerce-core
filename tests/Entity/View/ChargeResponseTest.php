<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class ChargeResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityChargeResponse = new Lib\PaymentGateway\ChargeResponse;
        $chargeResponse = $entityChargeResponse->getView();
        $this->assertTrue($chargeResponse instanceof ChargeResponse);
    }
}
