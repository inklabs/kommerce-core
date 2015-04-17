<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CashTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCash = new Entity\Payment\Cash(2000);

        $cash = $entityCash->getView()->export();

        $this->assertTrue($cash instanceof Payment\Cash);
    }
}
