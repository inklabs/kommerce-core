<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CatalogPromotionDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $catalogPromotion->setTag($this->dummyData->getTag());

        $catalogPromotionDTO = $catalogPromotion->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($catalogPromotionDTO instanceof CatalogPromotionDTO);
        $this->assertTrue($catalogPromotionDTO->tag instanceof TagDTO);
    }
}
