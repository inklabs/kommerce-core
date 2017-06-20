<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;
use inklabs\kommerce\Lib\UuidInterface;

class ProductTest extends EntityTestCase
{
    public function testStringOrNull()
    {
        $product = new Product;
        $product->setSku('');
        $product->setDescription('');
        $product->setDefaultImage('');

        $this->assertSame(null, $product->getSku());
        $this->assertSame(null, $product->getDescription());
        $this->assertSame(null, $product->getDefaultImage());
    }

    public function testRemoveTag()
    {
        $tag1 = $this->dummyData->getTag();
        $tag2 = $this->dummyData->getTag();

        $product = new Product;
        $product->addTag($tag1);
        $product->addTag($tag2);
        $this->assertSame(2, count($product->getTags()));

        $product->removeTag($tag2);
        $this->assertSame(1, count($product->getTags()));
    }

    public function testRemoveImage()
    {
        $image1 = $this->dummyData->getImage();
        $image2 = $this->dummyData->getImage();

        $product = new Product;
        $product->addImage($image1);
        $product->addImage($image2);
        $this->assertSame(2, count($product->getImages()));

        $product->removeImage($image2);
        $this->assertSame(1, count($product->getImages()));
    }

    public function testRemoveProductQuantityDiscount()
    {
        $productQuantityDiscount1 = $this->dummyData->getProductQuantityDiscount();
        $productQuantityDiscount2 = $this->dummyData->getProductQuantityDiscount();

        $product = new Product;
        $product->addProductQuantityDiscount($productQuantityDiscount1);
        $product->addProductQuantityDiscount($productQuantityDiscount2);
        $this->assertSame(2, count($product->getProductQuantityDiscounts()));

        $product->removeProductQuantityDiscount($productQuantityDiscount2);
        $this->assertSame(1, count($product->getProductQuantityDiscounts()));
    }

    public function testInStock()
    {
        $product = new Product;
        $product->setIsInventoryRequired(true);
        $product->setQuantity(5);
        $this->assertTrue($product->inStock());
    }

    public function testInStockWithoutInventoryRequired()
    {
        $product = new Product;
        $product->setIsInventoryRequired(false);
        $this->assertTrue($product->inStock());
    }

    public function testInStockReturnsFalseWhenLackingQuantity()
    {
        $product = new Product;
        $product->setIsInventoryRequired(true);
        $product->setQuantity(0);
        $this->assertFalse($product->inStock());
    }

    public function testGetPrice()
    {
        $pricing = $this->dummyData->getPricing();
        $product = new Product;
        $product->setQuantity(1);
        $this->assertTrue($product->getPrice($pricing) instanceof Price);
    }
}
