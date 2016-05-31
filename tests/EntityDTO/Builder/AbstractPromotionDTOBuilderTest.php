<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\EntityDTO\AbstractPromotionDTO;
use inklabs\kommerce\EntityDTO\PromotionTypeDTO;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

abstract class AbstractPromotionDTOBuilderTest extends EntityDTOBuilderTestCase
{
    /**
     * @return AbstractPromotion
     */
    abstract protected function getPromotion();

    /**
     * @return AbstractPromotionDTO
     */
    abstract protected function getPromotionDTO();

    public function testBuild()
    {
        $promotion = $this->getPromotion();
        $promotionDTO = $this->getPromotionDTO();

        $this->assertTrue($promotionDTO instanceof AbstractPromotionDTO);
        $this->assertTrue($promotionDTO->type instanceof PromotionTypeDTO);
    }
}
