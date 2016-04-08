<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper;

class OrderItemDTOBuilderTest extends Helper\DoctrineTestCase
{
    public function testBuild()
    {
        $orderItem = $this->dummyData->getOrderItemFull();

        $orderItemView = $orderItem->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemView instanceof OrderItemDTO);
        $this->assertTrue($orderItemView->price instanceof PriceDTO);
        $this->assertTrue($orderItemView->product instanceof ProductDTO);
        $this->assertTrue($orderItemView->catalogPromotions[0] instanceof CatalogPromotionDTO);
        $this->assertTrue($orderItemView->productQuantityDiscounts[0] instanceof ProductQuantityDiscountDTO);
        $this->assertTrue($orderItemView->orderItemOptionProducts[0] instanceof OrderItemOptionProductDTO);
        $this->assertTrue($orderItemView->orderItemOptionProducts[0]->optionProduct instanceof OptionProductDTO);
        $this->assertTrue($orderItemView->orderItemOptionProducts[0]->optionProduct->option instanceof OptionDTO);
        $this->assertTrue($orderItemView->orderItemOptionValues[0] instanceof OrderItemOptionValueDTO);
        $this->assertTrue($orderItemView->orderItemOptionValues[0]->optionValue instanceof OptionValueDTO);
        $this->assertTrue($orderItemView->orderItemOptionValues[0]->optionValue->option instanceof OptionDTO);
        $this->assertTrue($orderItemView->orderItemTextOptionValues[0] instanceof OrderItemTextOptionValueDTO);
        $this->assertTrue($orderItemView->orderItemTextOptionValues[0]->textOption instanceof TextOptionDTO);
    }
}
