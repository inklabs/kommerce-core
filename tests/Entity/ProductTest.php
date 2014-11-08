<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setUnitPrice(500);
        $this->product->setQuantity(10);
        $this->product->setIsInventoryRequired(true);
        $this->product->setIsPriceVisible(true);
        $this->product->setIsActive(true);
        $this->product->setIsVisible(true);
        $this->product->setIsTaxable(true);
        $this->product->setIsShippable(true);
        $this->product->setShippingWeight(16);
        $this->product->setDescription('Test product description');
        $this->product->setRating(null);
        $this->product->setDefaultImage(null);

        $this->tag = new Tag;
        $this->tag->setName('Test Tag');
        $this->product->addTag($this->tag);

        $this->image = new Image;
        $this->image->setPath('http://lorempixel.com/400/200/');
        $this->image->setWidth(400);
        $this->image->setHeight(200);
        $this->image->setSortOrder(0);
        $this->product->addImage($this->image);
    }

    public function testRequiredInStock()
    {
        $this->product->setIsInventoryRequired(true);

        $this->product->setQuantity(0);
        $this->assertFalse($this->product->inStock());

        $this->product->setQuantity(1);
        $this->assertTrue($this->product->inStock());
    }

    public function testNotRequiredInStock()
    {
        $this->product->setIsInventoryRequired(false);

        $this->assertTrue($this->product->inStock());
    }

    public function testGetRating()
    {
        $this->product->setRating(150);
        $this->assertSame(1.5, $this->product->getRating());

        $this->product->setRating(500);
        $this->assertSame(5, $this->product->getRating());
    }

    public function testaddProductQuantityDiscount()
    {
        $this->product = new Product;
        $this->product->addProductQuantityDiscount(new ProductQuantityDiscount);

        $this->assertEquals(1, count($this->product->getProductQuantityDiscounts()));
    }
}
