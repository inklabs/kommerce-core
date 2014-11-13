<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Entity\Product;
        $this->product->setSku('TST101');

        $this->viewProduct = Product::factory($this->product);
    }

    public function testWithAllData()
    {
        $pricing = new Service\Pricing();

        $viewProduct = $this->viewProduct
            ->withAllData($pricing)
            ->export();
        $this->assertEquals('TST101', $viewProduct->sku);
    }

    public function testWithImages()
    {
        $image = new Entity\Image;
        $image->setPath('xxx');

        $this->product->addImage($image);
        $this->viewProduct = Product::factory($this->product);

        $viewProduct = $this->viewProduct
            ->withImages()
            ->export();
        $this->assertEquals('xxx', $viewProduct->images[0]->path);
    }

    public function testWithTagsWithImages()
    {
        $image = new Entity\Image;
        $image->setPath('xxx');

        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->addImage($image);

        $this->product->addTag($tag);

        $this->viewProduct = Product::factory($this->product);

        $viewProduct = $this->viewProduct
            ->withTagsWithImages()
            ->export();
        $this->assertEquals('xxx', $viewProduct->tags[0]->images[0]->path);
    }
}
