<?php
namespace inklabs\kommerce\Action\Coupon\Query;

use inklabs\kommerce\EntityDTO\CouponDTO;

interface GetCouponResponseInterface
{
    public function setCouponDTO(CouponDTO $couponDTO);
}
