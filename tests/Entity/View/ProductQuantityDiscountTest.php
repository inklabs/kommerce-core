<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class ProductQuantityDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $this->productQuantityDiscount->setDiscountType('exact');
        $this->productQuantityDiscount->setQuantity(10);
        $this->productQuantityDiscount->setValue(500);

        $product = new Entity\Product;
        $product->setSku('TST1');
        $product->setUnitPrice(600);
        $this->productQuantityDiscount->setProduct($product);

        $this->viewProductQuantityDiscount = ProductQuantityDiscount::factory($this->productQuantityDiscount);
    }

    public function testWithAllData()
    {
        $pricing = new Service\Pricing();

        $viewProductQuantityDiscount = $this->viewProductQuantityDiscount
            ->withAllData($pricing)
            ->export();
        $this->assertEquals(500, $viewProductQuantityDiscount->value);
        $this->assertEquals('TST1', $viewProductQuantityDiscount->product->sku);
    }
}
