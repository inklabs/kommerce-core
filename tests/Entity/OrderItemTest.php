<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OrderItemTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setName('20% OFF Everything');
        $catalogPromotion->setType(CatalogPromotion::TYPE_PERCENT);
        $catalogPromotion->setValue(20);

        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setType(ProductQuantityDiscount::TYPE_EXACT);
        $productQuantityDiscount->setQuantity(2);
        $productQuantityDiscount->setValue(100);

        $product = new Product;
        $product->setSku('sku1');
        $product->setName('test name');
        $product->setUnitPrice(500);
        $product->setQuantity(10);
        $product->addProductQuantityDiscount($productQuantityDiscount);

        $logoProductQuantityDiscount = new ProductQuantityDiscount;
        $logoProductQuantityDiscount->setType(ProductQuantityDiscount::TYPE_FIXED);
        $logoProductQuantityDiscount->setQuantity(2);
        $logoProductQuantityDiscount->setValue(100);

        $logoProduct = new Product;
        $logoProduct->setSku('LAA');
        $logoProduct->setName('LA Angels');
        $logoProduct->setShippingWeight(6);
        $logoProduct->addProductQuantityDiscount($logoProductQuantityDiscount);

        $price = new Price;
        $price->origUnitPrice = 1;
        $price->unitPrice = 1;
        $price->origQuantityPrice = 1;
        $price->quantityPrice = 1;
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount);
        $price->addProductQuantityDiscount($logoProductQuantityDiscount);

        $orderItemOptionProduct = new OrderItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($this->getOptionProduct($logoProduct));

        $orderItemOptionValue = new OrderItemOptionValue;
        $orderItemOptionValue->setOptionValue($this->getOptionValue());

        $orderItemTextOptionValue = new OrderItemTextOptionValue;
        $orderItemTextOptionValue->setTextOption($this->getTextOption());
        $orderItemTextOptionValue->setTextOptionValue('Happy Birthday');

        $orderItem = new OrderItem;
        $orderItem->setProduct($product);
        $orderItem->setQuantity(2);
        $orderItem->setPrice($price);
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);
        $orderItem->addOrderItemTextOptionValue($orderItemTextOptionValue);

        $order = new Order;
        $order->addOrderItem($orderItem);
        $order->setTotal(new CartTotal);

        $this->assertEntityValid($orderItem);
        $this->assertSame(2, $orderItem->getQuantity());
        $this->assertSame('sku1-LAA-MD', $orderItem->getSku());
        $this->assertSame('test name', $orderItem->getName());
        $this->assertSame(
            '20% OFF Everything, Buy 2 or more for $1.00 each, Buy 2 or more for $1.00 off',
            $orderItem->getDiscountNames()
        );
        $this->assertSame(null, $orderItem->getId());
        $this->assertTrue($orderItem->getOrder() instanceof Order);
        $this->assertTrue($orderItem->getPrice() instanceof Price);
        $this->assertTrue($orderItem->getProduct() instanceof Product);
        $this->assertTrue($orderItem->getOrderItemOptionProducts()[0] instanceof OrderItemOptionProduct);
        $this->assertTrue($orderItem->getOrderItemOptionValues()[0] instanceof OrderItemOptionValue);
        $this->assertTrue($orderItem->getOrderItemTextOptionValues()[0] instanceof OrderItemTextOptionValue);
        $this->assertTrue($orderItem->getCatalogPromotions()[0] instanceof CatalogPromotion);
        $this->assertTrue($orderItem->getProductQuantityDiscounts()[0] instanceof ProductQuantityDiscount);
    }

    public function testCreateWithCustomItem()
    {
        $price = new Price;
        $price->origUnitPrice = 1;
        $price->unitPrice = 1;
        $price->origQuantityPrice = 1;
        $price->quantityPrice = 1;

        $orderItem = new OrderItem;
        $orderItem->setName('Free Entry Line Item');
        $orderItem->setQuantity(3);
        $orderItem->setPrice($price);

        $order = new Order;
        $order->addOrderItem($orderItem);
        $order->setTotal(new CartTotal);

        $this->assertEntityValid($orderItem);
        $this->assertSame(3, $orderItem->getQuantity());
        $this->assertSame(null, $orderItem->getSku());
        $this->assertSame('Free Entry Line Item', $orderItem->getName());
        $this->assertSame('', $orderItem->getDiscountNames());
        $this->assertSame(null, $orderItem->getId());
        $this->assertTrue($orderItem instanceof OrderItem);
    }

    public function testGetShippingWeight()
    {
        $product = new Product;
        $product->setShippingWeight(2);

        $orderItem = new OrderItem;
        $orderItem->setProduct($product);
        $orderItem->setQuantity(2);

        $this->assertSame(2, $orderItem->getShippingWeight());

        $product2 = new Product;
        $product2->setShippingWeight(3);
        $optionProduct = new OptionProduct;
        $optionProduct->setProduct($product2);
        $optionProduct->setOption(new Option);
        $orderItemOptionProduct = new OrderItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($optionProduct);
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);

        $this->assertSame(8, $orderItem->getShippingWeight());

        $optionValue = new OptionValue;
        $optionValue->setShippingWeight(4);
        $optionValue->setOption(new Option);
        $orderItemOptionValue = new OrderItemOptionValue;
        $orderItemOptionValue->setOptionValue($optionValue);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);

        $this->assertSame(12, $orderItem->getShippingWeight());
    }

    private function getOptionProduct(Product $product)
    {
        $option = new Option;
        $option->setType(Option::TYPE_SELECT);
        $option->setName('Team Logo');
        $option->setDescription('Embroidered Team Logo');

        $optionProduct = new OptionProduct;
        $optionProduct->setProduct($product);
        $optionProduct->setSortOrder(0);
        $optionProduct->setOption($option);

        return $optionProduct;
    }

    private function getOptionValue()
    {
        $option = new Option;
        $option->setType(Option::TYPE_SELECT);
        $option->setName('Shirt Size');
        $option->setDescription('Shirt Size Description');

        $optionValue = new OptionValue;
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
        $textOption = new TextOption;
        $textOption->setType(TextOption::TYPE_TEXTAREA);
        $textOption->setName('Custom Message');
        $textOption->setDescription('Custom engraved message');

        return $textOption;
    }
}
