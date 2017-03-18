<?php
namespace inklabs\kommerce\ActionResponse\Coupon;

use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;

class GetCouponResponse
{
    /** @var CouponDTOBuilder */
    protected $couponDTOBuilder;

    public function getCouponDTO()
    {
        return $this->couponDTOBuilder
            ->build();
    }

    public function setCouponDTOBuilder(CouponDTOBuilder $couponDTOBuilder)
    {
        $this->couponDTOBuilder = $couponDTOBuilder;
    }
}
