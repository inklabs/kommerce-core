<?php
namespace inklabs\kommerce\ActionResponse\Coupon;

use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetCouponResponse implements ResponseInterface
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
