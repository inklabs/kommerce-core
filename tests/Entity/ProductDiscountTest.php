<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\ProductQuantityDiscount;

class ProductQuantityDiscountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ProductDiscount::__construct
     */
    public function testConstruct()
    {
        $quantity_discount = new ProductQuantityDiscount;
        $quantity_discount->id = 1;
        $quantity_discount->name = '6x for $5 ea.';
        $quantity_discount->customer_group = null;
        $quantity_discount->discount_type = 'exact';
        $quantity_discount->quantity = 6;
        $quantity_discount->price = 500;
        $quantity_discount->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount->end   = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));
        $quantity_discount->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $quantity_discount->updated = null;

        $this->assertEquals(1, $quantity_discount->id);
    }
}
