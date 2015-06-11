<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use Symfony\Component\Validator\Validation;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $product = new Product;
        $this->assertSame(null, $product->getRating());

        $product->setSku(null);
        $product->setDescription(null);
        $this->assertSame(null, $product->getSku());
        $this->assertSame(null, $product->getDescription());

        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);
        $product->setQuantity(10);
        $product->setIsInventoryRequired(true);
        $product->setIsPriceVisible(true);
        $product->setIsActive(true);
        $product->setIsVisible(true);
        $product->setIsTaxable(true);
        $product->setIsShippable(true);
        $product->setShippingWeight(16);
        $product->setDescription('Test description');
        $product->setRating(500);
        $product->addTag(new Tag);
        $product->addImage(new Image);
        $product->setDefaultImage('http://lorempixel.com/400/200/');
        $product->addProductQuantityDiscount(new ProductQuantityDiscount);
        $product->addOptionProduct(new OptionProduct(new Product));
        $product->addProductAttribute(new ProductAttribute);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($product));
        $this->assertSame('TST101', $product->getSku());
        $this->assertSame('Test Product', $product->getName());
        $this->assertSame(500, $product->getUnitPrice());
        $this->assertSame(10, $product->getQuantity());
        $this->assertSame(true, $product->isInventoryRequired());
        $this->assertSame(true, $product->isPriceVisible());
        $this->assertSame(true, $product->isActive());
        $this->assertSame(true, $product->isVisible());
        $this->assertSame(true, $product->isTaxable());
        $this->assertSame(true, $product->isShippable());
        $this->assertSame(16, $product->getShippingWeight());
        $this->assertSame('Test description', $product->getDescription());
        $this->assertSame(5.0, $product->getRating());
        $this->assertSame('http://lorempixel.com/400/200/', $product->getDefaultImage());
        $this->assertTrue($product->getTags()[0] instanceof Tag);
        $this->assertTrue($product->getImages()[0] instanceof Image);
        $this->assertTrue($product->getProductQuantityDiscounts()[0] instanceof ProductQuantityDiscount);
        $this->assertTrue($product->getOptionProducts()[0] instanceof OptionProduct);
        $this->assertTrue($product->getProductAttributes()[0] instanceof ProductAttribute);
        $this->assertTrue($product->getView() instanceof View\Product);
    }

    public function testRemoveImage()
    {
        $product = new Product;
        $image = new Image;

        $product->addImage($image);
        $product->addImage(new Image);
        $this->assertSame(2, count($product->getImages()));

        $product->removeImage($image);
        $this->assertSame(1, count($product->getImages()));
    }

    public function testRemoveProductQuantityDiscount()
    {
        $product = new Product;
        $productQuantityDiscount = new ProductQuantityDiscount;

        $product->addProductQuantityDiscount($productQuantityDiscount);
        $product->addProductQuantityDiscount(new ProductQuantityDiscount);
        $this->assertSame(2, count($product->getProductQuantityDiscounts()));

        $product->removeProductQuantityDiscount($productQuantityDiscount);
        $this->assertSame(1, count($product->getProductQuantityDiscounts()));
    }

    public function testLoadFromView()
    {
        $product = new Product;
        $product->loadFromView(new View\Product(new Product));
        $this->assertTrue($product instanceof Product);
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
        $product = new Product;
        $product->setQuantity(1);
        $this->assertTrue($product->getPrice(new Lib\Pricing) instanceof Price);
    }
}
