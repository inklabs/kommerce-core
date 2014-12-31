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
        $productQuantityDiscount->setType(Entity\Promotion::TYPE_EXACT);
        $productQuantityDiscount->setQuantity(2);
        $productQuantityDiscount->setValue(400);

        $entityProduct->addProductQuantityDiscount($productQuantityDiscount);

        $product = $entityProduct->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($product->tags[0] instanceof Tag);
        $this->assertTrue($product->images[0] instanceof Image);
        $this->assertTrue($product->productQuantityDiscounts[0] instanceof ProductQuantityDiscount);
        $this->assertTrue($product->price instanceof Price);
    }

    public function testWithTagsWithImages()
    {
        $entityProduct = new Entity\Product;
        $entityProduct->addTag(new Entity\Tag);

        $product = $entityProduct->getView()
            ->withTagsWithImages(new Service\Pricing)
            ->export();

        $this->assertTrue($product->tags[0] instanceof Tag);
    }
}
