<?php
namespace inklabs\kommerce;

class CreatedTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->createdMock = new Entity\Product;
        $this->createdMock->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertInstanceOf('DateTime', $this->createdMock->getCreated());
    }
}
