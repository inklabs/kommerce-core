<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Tag;

class CatalogPromotionDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setTag(new Tag);

        $catalogPromotionDTO = $catalogPromotion->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($catalogPromotionDTO instanceof CatalogPromotionDTO);
        $this->assertTrue($catalogPromotionDTO->tag instanceof TagDTO);
    }
}
