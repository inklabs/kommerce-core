<?php
namespace inklabs\kommerce\Entity;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $image = new Image;
        $image->setId(1);
        $image->setPath('http://lorempixel.com/400/200/');
        $image->setWidth(400);
        $image->setHeight(200);
        $image->setSortOrder(0);
        $image->setProduct(new Product);
        $image->setTag(new Tag);

        $this->assertEquals(1, $image->getId());
        $this->assertEquals('http://lorempixel.com/400/200/', $image->getPath());
        $this->assertEquals(400, $image->getWidth());
        $this->assertEquals(200, $image->getHeight());
        $this->assertEquals(0, $image->getSortOrder());
        $this->assertInstanceOf('inklabs\kommerce\Entity\Product', $image->getProduct());
        $this->assertInstanceOf('inklabs\kommerce\Entity\Tag', $image->getTag());
    }
}
