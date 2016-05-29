<?php
namespace inklabs\kommerce\Action\Coupon\Query;

use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;

class GetCouponResponse implements GetCouponResponseInterface
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
