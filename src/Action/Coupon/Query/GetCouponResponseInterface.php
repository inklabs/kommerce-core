<?php
namespace inklabs\kommerce\Action\Coupon\Query;

use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;

interface GetCouponResponseInterface
{
    public function setCouponDTOBuilder(CouponDTOBuilder $couponDTOBuilder);
}
