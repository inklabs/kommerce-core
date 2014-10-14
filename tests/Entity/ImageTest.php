<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->image = new Image;
        $this->image->setPath('http://lorempixel.com/400/200/');
        $this->image->setWidth(400);
        $this->image->setHeight(200);
        $this->image->setSortOrder(0);
        $this->image->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetWidth()
    {
        $this->assertEquals(400, $this->image->getWidth());
    }
}
