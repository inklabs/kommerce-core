<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\tests\EntityDTO\Builder\AbstractPromotionDTOBuilderTest;

class CouponDTOBuilderTest extends AbstractPromotionDTOBuilderTest
{
    /**
     * @return Coupon
     */
    protected function getPromotion()
    {
        return $this->dummyData->getCoupon();
    }

    /**
     * @return CouponDTO
     */
    protected function getPromotionDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getCouponDTOBuilder($this->getPromotion())
            ->build();
    }

    public function testExtras()
    {
        $promotion = $this->getPromotion();
        $promotionDTO = $this->getPromotionDTO();

        $this->assertTrue($promotionDTO instanceof CouponDTO);
    }
}
