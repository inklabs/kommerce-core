<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\EntityDTO\PriceDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\EntityDTO\ProductQuantityDiscountDTO;
use inklabs\kommerce\tests\EntityDTO\Builder\AbstractPromotionDTOBuilderTest;

class ProductQuantityDiscountDTOBuilderTest extends AbstractPromotionDTOBuilderTest
{
    /**
     * @return ProductQuantityDiscount
     */
    protected function getPromotion()
    {
        return $this->dummyData->getProductQuantityDiscount();
    }

    /**
     * @return ProductQuantityDiscountDTO
     */
    protected function getPromotionDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getProductQuantityDiscountDTOBuilder($this->getPromotion())
            ->withAllData($this->dummyData->getPricing())
            ->build();
    }

    public function testExtras()
    {
        $promotion = $this->getPromotion();
        $promotionDTO = $this->getPromotionDTO();

        $this->assertTrue($promotionDTO instanceof ProductQuantityDiscountDTO);
        $this->assertTrue($promotionDTO->price instanceof PriceDTO);
        $this->assertTrue($promotionDTO->product instanceof ProductDTO);
    }
}
