<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class OrderItemOptionProductTest extends EntityTestCase
{
    public function testCreate()
    {
        $option = $this->dummyData->getOption();
        $option->setName('Team Logo');

        $product = $this->dummyData->getProduct();
        $product->setSku('LAA');
        $product->setName('LA Angels');

        $optionProduct = $this->dummyData->getOptionProduct($option, $product);
        $orderItem = $this->dummyData->getOrderItem();

        $orderItemOptionProduct = new OrderItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($optionProduct);
        $orderItemOptionProduct->setOrderItem($orderItem);

        $this->assertSame('LAA', $orderItemOptionProduct->getSku());
        $this->assertSame('Team Logo', $orderItemOptionProduct->getOptionName());
        $this->assertSame('LA Angels', $orderItemOptionProduct->getOptionProductName());
        $this->assertSame($optionProduct, $orderItemOptionProduct->getOptionProduct());
        $this->assertSame($orderItem, $orderItemOptionProduct->getOrderItem());
    }
}
