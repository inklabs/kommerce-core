<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class ChargeResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityChargeResponse = new Lib\PaymentGateway\ChargeResponse;
        $chargeResponse = $entityChargeResponse->getView()
            ->export();

        $this->assertTrue($chargeResponse instanceof ChargeResponse);
    }
}
