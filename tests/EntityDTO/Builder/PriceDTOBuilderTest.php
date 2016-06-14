<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class PriceDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $price = $this->dummyData->getPriceFull();

        $priceDTO = $this->getDTOBuilderFactory()
            ->getPriceDTOBuilder($price)
            ->withAllData()
            ->build();

        $this->assertTrue($priceDTO instanceof PriceDTO);
        $this->assertTrue($priceDTO->catalogPromotions[0] instanceof CatalogPromotionDTO);
        $this->assertTrue($priceDTO->productQuantityDiscounts[0] instanceof ProductQuantityDiscountDTO);
    }
}
