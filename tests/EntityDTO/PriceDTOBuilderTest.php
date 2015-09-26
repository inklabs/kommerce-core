<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\ProductQuantityDiscount;

class PriceDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $price = new Price;
        $price->addCatalogPromotion(new CatalogPromotion);
        $price->addProductQuantityDiscount(new ProductQuantityDiscount);

        $priceDTO = $price->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($priceDTO instanceof PriceDTO);
        $this->assertTrue($priceDTO->catalogPromotions[0] instanceof CatalogPromotionDTO);
        $this->assertTrue($priceDTO->productQuantityDiscounts[0] instanceof ProductQuantityDiscountDTO);
    }
}
