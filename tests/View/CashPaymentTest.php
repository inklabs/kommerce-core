<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CashPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCash = new Entity\CashPayment(2000);

        $cash = $entityCash->getView()->export();

        $this->assertTrue($cash instanceof CashPayment);
    }
}
