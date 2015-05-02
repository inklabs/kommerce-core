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

        $logoProductQuantityDiscount = new Entity\ProductQuantityDiscount;
        $logoProductQuantityDiscount->setType(Entity\ProductQuantityDiscount::TYPE_FIXED);
        $logoProductQuantityDiscount->setQuantity(2);
        $logoProductQuantityDiscount->setValue(100);

        $logoProduct = new Entity\Product;
        $logoProduct->setSku('LAA');
        $logoProduct->setName('LA Angels');
        $logoProduct->setShippingWeight(6);
        $logoProduct->addProductQuantityDiscount($logoProductQuantityDiscount);

        $orderItemOptionProduct = new Entity\OrderItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($this->getOptionProduct($logoProduct));

        $orderItemOptionValue = new Entity\OrderItemOptionValue;
        $orderItemOptionValue->setOptionValue($this->getOptionValue());

        $orderItemTextOptionValue = new Entity\OrderItemTextOptionValue;
        $orderItemTextOptionValue->setTextOption($this->getTextOption());
        $orderItemTextOptionValue->setTextOptionValue('Happy Birthday');

        $orderItem = new Entity\OrderItem;
        $orderItem->setProduct(new Entity\Product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice($price);
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);
        $orderItem->addOrderItemTextOptionValue($orderItemTextOptionValue);

        $orderItemView = $orderItem->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($orderItemView instanceof OrderItem);
        $this->assertTrue($orderItemView->price instanceof Price);
        $this->assertTrue($orderItemView->product instanceof Product);
        $this->assertTrue($orderItemView->catalogPromotions[0] instanceof CatalogPromotion);
        $this->assertTrue($orderItemView->productQuantityDiscounts[0] instanceof ProductQuantityDiscount);
        $this->assertTrue($orderItemView->orderItemOptionProducts[0] instanceof OrderItemOptionProduct);
        $this->assertTrue($orderItemView->orderItemOptionValues[0] instanceof OrderItemOptionValue);
        $this->assertTrue($orderItemView->orderItemTextOptionValues[0] instanceof OrderItemTextOptionValue);
    }

    private function getOptionProduct(Entity\Product $product)
    {
        $option = new Entity\Option;
        $option->setType(Entity\Option::TYPE_SELECT);
        $option->setName('Team Logo');
        $option->setDescription('Embroidered Team Logo');

        $optionProduct = new Entity\OptionProduct;
        $optionProduct->setProduct($product);
        $optionProduct->setSortOrder(0);
        $optionProduct->setOption($option);

        return $optionProduct;
    }

    private function getOptionValue()
    {
        $option = new Entity\Option;
        $option->setType(Entity\Option::TYPE_SELECT);
        $option->setName('Shirt Size');
        $option->setDescription('Shirt Size Description');

        $optionValue = new Entity\OptionValue;
        $optionValue->setSortOrder(0);
        $optionValue->setSku('MD');
        $optionValue->setName('Medium Shirt');
        $optionValue->setShippingWeight(0);
        $optionValue->setUnitPrice(500);
        $optionValue->setOption($option);

        return $optionValue;
    }

    private function getTextOption()
    {
        $textOption = new Entity\TextOption;
        $textOption->setType(Entity\TextOption::TYPE_TEXTAREA);
        $textOption->setName('Custom Message');
        $textOption->setDescription('Custom engraved message');

        return $textOption;
    }
}
