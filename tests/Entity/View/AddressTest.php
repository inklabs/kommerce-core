<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityAddress = new Entity\Address;

        $address = $entityAddress->getView();

        $this->assertTrue($address instanceof Address);
    }
}
