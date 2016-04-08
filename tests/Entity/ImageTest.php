<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ImageTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $image = new Image;

        $this->assertSame(null, $image->getPath());
        $this->assertSame(null, $image->getWidth());
        $this->assertSame(null, $image->getHeight());
        $this->assertSame(0, $image->getSortOrder());
        $this->assertSame(null, $image->getProduct());
        $this->assertSame(null, $image->getTag());
    }

    public function testCreate()
    {
        $product = $this->dummyData->getProduct();
        $tag = $this->dummyData->getTag();

        $image = new Image;
        $image->setPath('http://lorempixel.com/400/200/');
        $image->setWidth(400);
        $image->setHeight(200);
        $image->setSortOrder(2);
        $image->setProduct($product);
        $image->setTag($tag);

        $this->assertEntityValid($image);
        $this->assertSame('http://lorempixel.com/400/200/', $image->getPath());
        $this->assertSame(400, $image->getWidth());
        $this->assertSame(200, $image->getHeight());
        $this->assertSame(2, $image->getSortOrder());
        $this->assertSame($product, $image->getProduct());
        $this->assertSame($tag, $image->getTag());
    }
}
