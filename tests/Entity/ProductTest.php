<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;
use Symfony\Component\Validator\Validation;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $product = new Product;
        $this->assertSame(null, $product->getRating());

        $product->setId(1);
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
        $product->setDefaultImage('http://lorempixel.com/400/200/');
        $product->addTag(new Tag);
        $product->addImage(new Image);
        $product->addProductQuantityDiscount(new ProductQuantityDiscount);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($product));
        $this->assertSame(1, $product->getId());
        $this->assertSame('TST101', $product->getSku());
        $this->assertSame('Test Product', $product->getName());
        $this->assertSame(500, $product->getUnitPrice());
        $this->assertSame(10, $product->getQuantity());
        $this->assertSame(true, $product->getIsInventoryRequired());
        $this->assertSame(true, $product->getIsPriceVisible());
        $this->assertSame(true, $product->getIsActive());
        $this->assertSame(true, $product->getIsVisible());
        $this->assertSame(true, $product->getIsTaxable());
        $this->assertSame(true, $product->getIsShippable());
        $this->assertSame(16, $product->getShippingWeight());
        $this->assertSame('Test description', $product->getDescription());
        $this->assertSame(5.0, $product->getRating());
        $this->assertSame('http://lorempixel.com/400/200/', $product->getDefaultImage());
        $this->assertTrue($product->getTags()[0] instanceof Tag);
        $this->assertTrue($product->getImages()[0] instanceof Image);
        $this->assertTrue($product->getProductQuantityDiscounts()[0] instanceof ProductQuantityDiscount);
        $this->assertTrue($product->getView() instanceof View\Product);
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
        $this->assertTrue($product->getPrice(new Service\Pricing) instanceof Price);
    }
}
