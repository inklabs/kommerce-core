<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Accessor\Updated;

class UpdatedTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->updatedMock = new Entity\Product;
        $this->updatedMock->setUpdated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertInstanceOf('DateTime', $this->updatedMock->getUpdated());
    }
}
