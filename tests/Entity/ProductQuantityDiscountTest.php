<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\Exception\BadMethodCallException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ProductQuantityDiscountTest extends EntityTestCase
{
    /** @var Product */
    protected $product;

    /** @var ProductQuantityDiscount */
    protected $productQuantityDiscount;

    public function setUp()
    {
        parent::setUp();
        $this->product = $this->dummyData->getProduct();
        $this->productQuantityDiscount = new ProductQuantityDiscount($this->product);
    }

    public function testCreate()
    {
        $pricing = $this->dummyData->getPricing();

        $this->productQuantityDiscount->setQuantity(6);
        $this->productQuantityDiscount->setFlagApplyCatalogPromotions(true);

        $this->assertEntityValid($this->productQuantityDiscount);
        $this->assertSame(6, $this->productQuantityDiscount->getQuantity());
        $this->assertSame(true, $this->productQuantityDiscount->getFlagApplyCatalogPromotions());
        $this->assertSame($this->product, $this->productQuantityDiscount->getProduct());
        $this->assertTrue($this->productQuantityDiscount->getPrice($pricing) instanceof Price);
    }

    public function testSetNameThrowsException()
    {
        $product = $this->dummyData->getProduct();
        $this->productQuantityDiscount = new ProductQuantityDiscount($product);

        $this->setExpectedException(
            BadMethodCallException::class,
            'Unable to set name'
        );

        $this->productQuantityDiscount->setName('test');
    }

    public function testIsQuantityValid()
    {
        $product = $this->dummyData->getProduct();
        $this->productQuantityDiscount = new ProductQuantityDiscount($product);
        $this->productQuantityDiscount->setQuantity(5);
        $this->assertTrue($this->productQuantityDiscount->isQuantityValid(6));
    }

    public function testIsQuantityValidReturnsFalse()
    {
        $this->productQuantityDiscount->setQuantity(5);
        $this->assertFalse($this->productQuantityDiscount->isQuantityValid(4));
    }

    public function testIsValid()
    {
        $this->productQuantityDiscount->setQuantity(5);
        $this->assertTrue($this->productQuantityDiscount->isValid(new DateTime, 6));
    }

    public function testGetNameExact()
    {
        $this->productQuantityDiscount->setType(PromotionType::exact());
        $this->productQuantityDiscount->setQuantity(10);
        $this->productQuantityDiscount->setValue(500);
        $this->assertSame('Buy 10 or more for $5.00 each', $this->productQuantityDiscount->getName());
    }

    public function testGetNamePercent()
    {
        $this->productQuantityDiscount->setType(PromotionType::percent());
        $this->productQuantityDiscount->setQuantity(10);
        $this->productQuantityDiscount->setValue(50);
        $this->assertSame('Buy 10 or more for 50% off', $this->productQuantityDiscount->getName());
    }

    public function testGetNameFixed()
    {
        $this->productQuantityDiscount->setType(PromotionType::fixed());
        $this->productQuantityDiscount->setQuantity(10);
        $this->productQuantityDiscount->setValue(500);
        $this->assertSame('Buy 10 or more for $5.00 off', $this->productQuantityDiscount->getName());
    }
}
