<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Product;
        // $this->product->setId(1);
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setPrice(500);
        $this->product->setQuantity(10);
        // $this->product->setProduct_group_id(null);
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
        $this->product->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetSku()
    {
        $this->assertEquals('TST101', $this->product->getSku());
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

    public function testaddQuantityDiscount()
    {
        $this->product = new Product;
        $this->product->addQuantityDiscount(new ProductQuantityDiscount);

        $this->assertEquals(1, count($this->product->getQuantityDiscounts()));
    }
}
