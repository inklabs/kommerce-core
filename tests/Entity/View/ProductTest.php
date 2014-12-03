<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityProduct = new Entity\Product;
        $entityProduct->addTag(new Entity\Tag);
        $entityProduct->addImage(new Entity\Image);

        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setType('exact');
        $productQuantityDiscount->setQuantity(2);
        $productQuantityDiscount->setValue(400);

        $entityProduct->addProductQuantityDiscount($productQuantityDiscount);

        $product = Product::factory($entityProduct)
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Tag', $product->tags[0]);
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Image', $product->images[0]);
        $this->assertInstanceOf(
            'inklabs\kommerce\Entity\View\ProductQuantityDiscount',
            $product->productQuantityDiscounts[0]
        );
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Price', $product->price);
    }

    public function testWithTagsWithImages()
    {
        $entityProduct = new Entity\Product;
        $entityProduct->addTag(new Entity\Tag);

        $product = Product::factory($entityProduct)
            ->withTagsWithImages(new Service\Pricing)
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Tag', $product->tags[0]);
    }
}
