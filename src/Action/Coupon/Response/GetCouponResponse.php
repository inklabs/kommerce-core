<?php
namespace inklabs\kommerce\Action\Coupon\Response;

use inklabs\kommerce\EntityDTO\CouponDTO;

final class GetCouponResponse implements GetCouponResponseInterface
{
    /** @var CouponDTO */
    protected $couponDTO;

    public function setCouponDTO(CouponDTO $couponDTO)
    {
        $this->couponDTO = $couponDTO;
    }

    public function getCouponDTO()
    {
        return $this->couponDTO;
    }
}
