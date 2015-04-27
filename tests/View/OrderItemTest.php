<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class OrderItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $price = new Entity\Price;
        $price->addCatalogPromotion(new Entity\CatalogPromotion);
        $price->addProductQuantityDiscount(new Entity\ProductQuantityDiscount);

        $optionValueProduct = new Entity\OptionProduct(new Entity\Product);
        $optionValueProduct->setProduct(new Entity\Product);
        $optionValueProduct->setOptionType(new Entity\OptionType\Option);

        $orderItemOptionValue = new Entity\OrderItemOptionValue($optionValueProduct);

        $orderItem = new Entity\OrderItem;
        $orderItem->setProduct(new Entity\Product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice($price);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);

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
