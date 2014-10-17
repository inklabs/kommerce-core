<?php
namespace inklabs\kommerce;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->image = new Entity\Image;
        $this->image->setPath('http://lorempixel.com/400/200/');
        $this->image->setWidth(400);
        $this->image->setHeight(200);
        $this->image->setSortOrder(0);
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->image->getId());
        $this->assertEquals('http://lorempixel.com/400/200/', $this->image->getPath());
        $this->assertEquals(400, $this->image->getWidth());
        $this->assertEquals(200, $this->image->getHeight());
        $this->assertEquals(0, $this->image->getSortOrder());
    }
}
