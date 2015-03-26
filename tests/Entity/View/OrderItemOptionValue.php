<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class OrderItemOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $price = new Entity\Price;
        $price->addCatalogPromotion(new Entity\CatalogPromotion);
        $price->addProductQuantityDiscount(new Entity\ProductQuantityDiscount);

        $optionValue = new Entity\OptionValue;
        $optionValue->setOption(new Entity\Option);
        $optionValue->setProduct(new Entity\Product);

        $orderItem = new Entity\OrderItem(new Entity\Product, 1, $price);
        $orderItem->addOrderItemOptionValue(new Entity\OrderItemOptionValue($optionValue));

        $orderItemView = $orderItem->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($orderItemView instanceof OrderItem);
        $this->assertTrue($orderItemView->price instanceof Price);
        $this->assertTrue($orderItemView->product instanceof Product);
        $this->assertTrue($orderItemView->catalogPromotions[0] instanceof CatalogPromotion);
        $this->assertTrue($orderItemView->productQuantityDiscounts[0] instanceof ProductQuantityDiscount);
        $this->assertTrue($orderItemView->orderItemOptionValues[0] instanceof OrderItemOptionValue);
    }
}
