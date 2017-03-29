<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\tests\EntityDTO\Builder\AbstractPromotionDTOBuilderTest;

class CatalogPromotionDTOBuilderTest extends AbstractPromotionDTOBuilderTest
{
    /**
     * @return CatalogPromotion
     */
    protected function getPromotion()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $catalogPromotion->setTag($this->dummyData->getTag());
        return $catalogPromotion;
    }

    /**
     * @return CatalogPromotionDTO
     */
    protected function getPromotionDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getCatalogPromotionDTOBuilder($this->getPromotion())
            ->withAllData()
            ->build();
    }

    public function testBuild()
    {
        $promotion = $this->getPromotion();
        $promotionDTO = $this->getPromotionDTO();

        $this->assertTrue($promotionDTO instanceof CatalogPromotionDTO);
        $this->assertTrue($promotionDTO->tag instanceof TagDTO);
    }
}
