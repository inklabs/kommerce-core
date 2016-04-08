<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\Product;

class OrderItemOptionProductDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $optionProduct = new OptionProduct;
        $optionProduct->setOption(new Option);
        $optionProduct->setProduct(new Product);

        $orderItemOptionProduct = new OrderItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($optionProduct);
        $orderItemOptionProduct->setOrderItem(new OrderItem);

        $orderItemOptionProductDTO = $orderItemOptionProduct->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemOptionProductDTO instanceof OrderItemOptionProductDTO);
        $this->assertTrue($orderItemOptionProductDTO->optionProduct instanceof OptionProductDTO);
        $this->assertTrue($orderItemOptionProductDTO->optionProduct->option instanceof OptionDTO);
    }
}
