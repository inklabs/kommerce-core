<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class ProductQuantityDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityProductQuantityDiscount = new Entity\ProductQuantityDiscount;
        $entityProductQuantityDiscount->setProduct(new Entity\Product);

        $productQuantityDiscount = $entityProductQuantityDiscount->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($productQuantityDiscount->price instanceof Price);
        $this->assertTrue($productQuantityDiscount->product instanceof Product);
    }
}
