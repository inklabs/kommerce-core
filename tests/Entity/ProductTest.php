<?php
namespace inklabs\kommerce\Entity;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Product;
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

        $this->price = new Price;
        $this->product->setPriceObj($this->price);
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->product->getId());
        $this->assertEquals('TST101', $this->product->getSku());
        $this->assertEquals('Test Product', $this->product->getName());
        $this->assertEquals(500, $this->product->getPrice());
        $this->assertEquals(10, $this->product->getQuantity());
        $this->assertEquals(true, $this->product->getIsInventoryRequired());
        $this->assertEquals(true, $this->product->getIsPriceVisible());
        $this->assertEquals(true, $this->product->getIsActive());
        $this->assertEquals(true, $this->product->getIsVisible());
        $this->assertEquals(true, $this->product->getIsTaxable());
        $this->assertEquals(true, $this->product->getIsShippable());
        $this->assertEquals(16, $this->product->getShippingWeight());
        $this->assertEquals('Test product description', $this->product->getDescription());
        $this->assertEquals(null, $this->product->getRating());
        $this->assertEquals(null, $this->product->getDefaultImage());
        $this->assertEquals($this->price, $this->product->getPriceObj());
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
