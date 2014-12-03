<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class ProductQuantityDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setCustomerGroup(null);
        $productQuantityDiscount->setQuantity(6);
        $productQuantityDiscount->setFlagApplyCatalogPromotions(true);
        $productQuantityDiscount->setProduct(new Product);

        $this->assertEquals(null, $productQuantityDiscount->getCustomerGroup());
        $this->assertEquals(6, $productQuantityDiscount->getQuantity());
        $this->assertEquals(true, $productQuantityDiscount->getFlagApplyCatalogPromotions());
        $this->assertInstanceOf('inklabs\kommerce\Entity\Product', $productQuantityDiscount->getProduct());
    }

    /**
     * @expectedException \Exception
     */
    public function testSetNameThrowsException()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setName('test');
    }

    public function testIsQuantityValid()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setQuantity(5);
        $this->assertTrue($productQuantityDiscount->isQuantityValid(6));
    }

    public function testIsQuantityValidReturnsFalse()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setQuantity(5);
        $this->assertFalse($productQuantityDiscount->isQuantityValid(4));
    }

    public function testIsValid()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setQuantity(5);
        $this->assertTrue($productQuantityDiscount->isValid(new \DateTime, 6));
    }

    public function testGetNameExact()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setType('exact');
        $productQuantityDiscount->setQuantity(10);
        $productQuantityDiscount->setValue(500);
        $this->assertEquals('Buy 10 or more for $5.00 each', $productQuantityDiscount->getName());
    }

    public function testGetNamePercent()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setType('percent');
        $productQuantityDiscount->setQuantity(10);
        $productQuantityDiscount->setValue(50);
        $this->assertEquals('Buy 10 or more for 50% off', $productQuantityDiscount->getName());
    }

    public function testGetNameFixed()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setType('fixed');
        $productQuantityDiscount->setQuantity(10);
        $productQuantityDiscount->setValue(500);
        $this->assertEquals('Buy 10 or more for $5.00 off', $productQuantityDiscount->getName());
    }

    public function testGetPrice()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setProduct(new Product);
        $productQuantityDiscount->setQuantity(1);
        $this->assertInstanceOf(
            'inklabs\kommerce\Entity\Price',
            $productQuantityDiscount->getPrice(new Service\Pricing)
        );
    }
}
