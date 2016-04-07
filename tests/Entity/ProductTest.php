<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ProductTest extends DoctrineTestCase
{
    public function testCreateDefaults()
    {
        $product = new Product;

        $this->assertSame(null, $product->getSku());
        $this->assertSame(null, $product->getName());
        $this->assertSame(null, $product->getDescription());
        $this->assertSame(null, $product->getDefaultImage());
        $this->assertSame(0, $product->getUnitPrice());
        $this->assertSame(0, $product->getQuantity());
        $this->assertSame(0, $product->getShippingWeight());
        $this->assertSame(null, $product->getRating());
        $this->assertFalse($product->isInventoryRequired());
        $this->assertFalse($product->isPriceVisible());
        $this->assertFalse($product->isActive());
        $this->assertFalse($product->isVisible());
        $this->assertFalse($product->isTaxable());
        $this->assertFalse($product->isShippable());
        $this->assertSame(0, count($product->getTags()));
        $this->assertSame(0, count($product->getImages()));
        $this->assertSame(0, count($product->getProductQuantityDiscounts()));
        $this->assertSame(0, count($product->getOptionProducts()));
        $this->assertSame(0, count($product->getProductAttributes()));
    }

    public function testCreate()
    {
        $tag = $this->dummyData->getTag();
        $image = $this->dummyData->getImage();
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount();
        $optionProduct = $this->dummyData->getOptionProduct();
        $productAttribute = $this->dummyData->getProductAttribute();

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setDescription('Test description');
        $product->setDefaultImage('http://lorempixel.com/400/200/');
        $product->setUnitPrice(500);
        $product->setQuantity(10);
        $product->setShippingWeight(16);
        $product->setRating(500);
        $product->setIsInventoryRequired(true);
        $product->setIsPriceVisible(true);
        $product->setIsActive(true);
        $product->setIsVisible(true);
        $product->setIsTaxable(true);
        $product->setIsShippable(true);
        $product->addTag($tag);
        $product->addImage($image);
        $product->addProductQuantityDiscount($productQuantityDiscount);
        $product->addOptionProduct($optionProduct);
        $product->addProductAttribute($productAttribute);

        $this->assertEntityValid($product);
        $this->assertSame('TST101', $product->getSku());
        $this->assertSame('Test Product', $product->getName());
        $this->assertSame('Test description', $product->getDescription());
        $this->assertSame('http://lorempixel.com/400/200/', $product->getDefaultImage());
        $this->assertSame(500, $product->getUnitPrice());
        $this->assertSame(10, $product->getQuantity());
        $this->assertSame(16, $product->getShippingWeight());
        $this->assertSame(5.0, $product->getRating());
        $this->assertSame(true, $product->isInventoryRequired());
        $this->assertSame(true, $product->isPriceVisible());
        $this->assertSame(true, $product->isActive());
        $this->assertSame(true, $product->isVisible());
        $this->assertSame(true, $product->isTaxable());
        $this->assertSame(true, $product->isShippable());
        $this->assertSame($tag, $product->getTags()[0]);
        $this->assertSame($image, $product->getImages()[0]);
        $this->assertSame($productQuantityDiscount, $product->getProductQuantityDiscounts()[0]);
        $this->assertSame($optionProduct, $product->getOptionProducts()[0]);
        $this->assertSame($productAttribute, $product->getProductAttributes()[0]);
    }

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
