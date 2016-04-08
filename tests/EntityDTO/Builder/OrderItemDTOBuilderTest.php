<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper;

class OrderItemDTOBuilderTest extends Helper\TestCase\EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $orderItem = $this->dummyData->getOrderItemFull();

        $orderItemDTO = $orderItem->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemDTO instanceof OrderItemDTO);
        $this->assertTrue($orderItemDTO->price instanceof PriceDTO);
        $this->assertTrue($orderItemDTO->product instanceof ProductDTO);
        $this->assertTrue($orderItemDTO->catalogPromotions[0] instanceof CatalogPromotionDTO);
        $this->assertTrue($orderItemDTO->productQuantityDiscounts[0] instanceof ProductQuantityDiscountDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionProducts[0] instanceof OrderItemOptionProductDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionProducts[0]->optionProduct instanceof OptionProductDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionProducts[0]->optionProduct->option instanceof OptionDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionValues[0] instanceof OrderItemOptionValueDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionValues[0]->optionValue instanceof OptionValueDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionValues[0]->optionValue->option instanceof OptionDTO);
        $this->assertTrue($orderItemDTO->orderItemTextOptionValues[0] instanceof OrderItemTextOptionValueDTO);
        $this->assertTrue($orderItemDTO->orderItemTextOptionValues[0]->textOption instanceof TextOptionDTO);
    }
}
