<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tag = new Entity\Tag;
        $this->tag->setName('Test Tag');
    }

    public function testWithAllData()
    {
        $image = new Entity\Image;
        $image->setPath('xxx');
        $this->tag->addImage($image);

        $product = new Entity\Product;
        $product->setSku('TST1');
        $this->tag->addProduct($product);

        $this->viewTag = Tag::factory($this->tag);

        $pricing = new Service\Pricing();

        $viewTag = $this->viewTag
            ->withAllData($pricing)
            ->export();
        $this->assertEquals('Test Tag', $viewTag->name);
        $this->assertEquals('xxx', $viewTag->images[0]->path);
        $this->assertEquals('TST1', $viewTag->products[0]->sku);
    }
}
