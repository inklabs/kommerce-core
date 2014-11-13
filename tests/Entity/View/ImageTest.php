<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->image = new Entity\Image;
        $this->image->setPath('xxx');

        $this->viewImage = Image::factory($this->image);
    }

    public function testWithAllData()
    {
        $viewImage = $this->viewImage
            ->withAllData()
            ->export();
        $this->assertEquals('xxx', $viewImage->path);
    }

    public function testWithTag()
    {
        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $this->image->setTag($tag);

        $this->viewImage = Image::factory($this->image);

        $viewImage = $this->viewImage
            ->withTag()
            ->export();
        $this->assertEquals('xxx', $viewImage->path);
        $this->assertEquals('Test Tag', $viewImage->tag->name);
    }

    public function testWithProduct()
    {
        $product = new Entity\Product;
        $product->setSku('TST1');
        $this->image->setProduct($product);

        $this->viewImage = Image::factory($this->image);

        $viewImage = $this->viewImage
            ->withProduct()
            ->export();
        $this->assertEquals('xxx', $viewImage->path);
        $this->assertEquals('TST1', $viewImage->product->sku);
    }
}
