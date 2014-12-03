<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class ProductQuantityDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityProductQuantityDiscount = new Entity\ProductQuantityDiscount;
        $entityProductQuantityDiscount->setProduct(new Entity\Product);

        $productQuantityDiscount = ProductQuantityDiscount::factory($entityProductQuantityDiscount)
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Price', $productQuantityDiscount->price);
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Product', $productQuantityDiscount->product);
    }
}
