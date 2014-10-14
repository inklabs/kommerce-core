<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Accessor\Created;

class CreatedMock
{
    use Created;
}

class CreatedTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->createdMock = new CreatedMock;
        $this->createdMock->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertInstanceOf('DateTime', $this->createdMock->getCreated());
    }
}
