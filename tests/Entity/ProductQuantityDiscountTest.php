<?php
namespace inklabs\kommerce;

class ProductQuantityDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->quantityDiscount = new Entity\ProductQuantityDiscount;
        $this->quantityDiscount->setName('6x for $5 ea.');
        $this->quantityDiscount->setCustomerGroup(null);
        $this->quantityDiscount->setDiscountType('exact');
        $this->quantityDiscount->setQuantity(6);
        $this->quantityDiscount->setValue(500);
        $this->quantityDiscount->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->quantityDiscount->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $this->quantityDiscount->setcreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->quantityDiscount->getCustomerGroup());
        $this->assertEquals(6, $this->quantityDiscount->getQuantity());
    }
}
