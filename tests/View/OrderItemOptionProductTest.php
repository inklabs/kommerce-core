<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class OrderItemOptionProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionProduct = new Entity\OptionProduct;
        $optionProduct->setOption(new Entity\Option);
        $optionProduct->setProduct(new Entity\Product);

        $orderItemOptionProduct = new Entity\OrderItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($optionProduct);
        $orderItemOptionProduct->setOrderItem(new Entity\OrderItem);

        $viewOrderItemOptionProduct = $orderItemOptionProduct->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($viewOrderItemOptionProduct instanceof OrderItemOptionProduct);
    }
}
