<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class CreditTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $chargeRequest = new Lib\PaymentGateway\ChargeRequest(
            new Entity\CreditCard('4242424242424242', '01', '2014'),
            2000,
            'usd',
            'john@example.com'
        );
        $entityCredit = new Entity\Payment\Credit($chargeRequest, new Lib\PaymentGateway\StripeStub);

        $credit = $entityCredit->getView()->export();

        $this->assertTrue($credit instanceof Payment\Credit);
        $this->assertTrue($credit->charge instanceof ChargeResponse);
    }
}
