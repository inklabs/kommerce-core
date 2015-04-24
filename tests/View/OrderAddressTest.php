<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class OrderAddressTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityOrderAddress = new Entity\OrderAddress;

        $address = $entityOrderAddress->getView()
            ->export();

        $this->assertTrue($address instanceof OrderAddress);
    }
}
