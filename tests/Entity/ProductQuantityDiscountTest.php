<?php
namespace inklabs\kommerce\Entity;

class ProductQuantityDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->productQuantityDiscount = new ProductQuantityDiscount;
        $this->productQuantityDiscount->setName('6x for $5 ea.');
        $this->productQuantityDiscount->setCustomerGroup(null);
        $this->productQuantityDiscount->setDiscountType('exact');
        $this->productQuantityDiscount->setQuantity(6);
        $this->productQuantityDiscount->setValue(500);
        $this->productQuantityDiscount->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->productQuantityDiscount->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->productQuantityDiscount->getCustomerGroup());
        $this->assertEquals(6, $this->productQuantityDiscount->getQuantity());
    }
}
