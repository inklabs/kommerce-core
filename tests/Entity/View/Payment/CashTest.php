<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class CashTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCash = new Entity\Payment\Cash(2000);

        $cash = $entityCash->getView()->export();

        $this->assertTrue($cash instanceof Payment\Cash);
    }
}
