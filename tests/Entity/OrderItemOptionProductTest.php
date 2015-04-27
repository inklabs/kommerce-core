<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class OrderItemOptionProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $option = new Option;
        $option->setType(Option::TYPE_SELECT);
        $option->setName('Team Logo');
        $option->setDescription('Embroidered Team Logo');

        $logoProduct = new Product;
        $logoProduct->setSku('LAA');
        $logoProduct->setName('LA Angels');
        $logoProduct->setShippingWeight(6);

        $optionProduct = new OptionProduct;
        $optionProduct->setProduct($logoProduct);
        $optionProduct->setSortOrder(0);
        $optionProduct->setOption($option);

        $orderItemOptionProduct = new OrderItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($optionProduct);

        $product = new Product;
        $product->setSku('MS');
        $product->setName('Medium Polo Shirt');
        $product->setShippingWeight(16);

        $orderItem = new OrderItem;
        $orderItem->setProduct($product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice($product->getPrice(new Service\Pricing));
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);

        $this->assertSame('LAA', $orderItemOptionProduct->getSku());
        $this->assertSame('Team Logo', $orderItemOptionProduct->getOptionName());
        $this->assertSame('LA Angels', $orderItemOptionProduct->getOptionProductName());
        $this->assertTrue($orderItemOptionProduct->getOptionProduct() instanceof OptionProduct);
        $this->assertTrue($orderItemOptionProduct->getOrderItem() instanceof OrderItem);
        $this->assertTrue($orderItemOptionProduct->getView() instanceof View\OrderItemOptionProduct);
    }
}
