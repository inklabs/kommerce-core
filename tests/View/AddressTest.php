<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityAddress = new Entity\Address;

        $address = $entityAddress->getView();

        $this->assertTrue($address instanceof Address);
    }
}
