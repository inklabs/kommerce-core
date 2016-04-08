<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class PriceDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $price = $this->dummyData->getPriceFull();

        $priceDTO = $price->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($priceDTO instanceof PriceDTO);
        $this->assertTrue($priceDTO->catalogPromotions[0] instanceof CatalogPromotionDTO);
        $this->assertTrue($priceDTO->productQuantityDiscounts[0] instanceof ProductQuantityDiscountDTO);
    }
}
