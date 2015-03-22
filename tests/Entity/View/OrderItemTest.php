<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class OrderItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $price = new Entity\Price;
        $price->addCatalogPromotion(new Entity\CatalogPromotion);
        $price->addProductQuantityDiscount(new Entity\ProductQuantityDiscount);

        $orderItem = new Entity\OrderItem(new Entity\Product, 1, $price);

        $orderItemView = $orderItem->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($orderItemView instanceof OrderItem);
        $this->assertTrue($orderItemView->price instanceof Price);
        $this->assertTrue($orderItemView->product instanceof Product);
        $this->assertTrue($orderItemView->catalogPromotions[0] instanceof CatalogPromotion);
        $this->assertTrue($orderItemView->productQuantityDiscounts[0] instanceof ProductQuantityDiscount);
    }
}
