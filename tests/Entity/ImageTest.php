<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ImageTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $path = 'http://lorempixel.com/400/200/';
        $width = 400;
        $height = 200;
        $image = new Image($path, $width, $height);

        $this->assertSame($path, $image->getPath());
        $this->assertSame($width, $image->getWidth());
        $this->assertSame($height, $image->getHeight());
        $this->assertSame(0, $image->getSortOrder());
        $this->assertSame(null, $image->getProduct());
        $this->assertSame(null, $image->getTag());
    }

    public function testCreate()
    {
        $product = $this->dummyData->getProduct();
        $tag = $this->dummyData->getTag();

        $path = 'http://lorempixel.com/300/100/';
        $width = 300;
        $height = 100;
        $image = new Image($path, $width, $height);
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
