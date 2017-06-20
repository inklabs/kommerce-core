<?php
namespace inklabs\kommerce\ActionResponse\Coupon;

use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetCouponResponse implements ResponseInterface
{
    /** @var CouponDTOBuilder */
    protected $couponDTOBuilder;

    public function getCouponDTO(): CouponDTO
    {
        return $this->couponDTOBuilder
            ->build();
    }

    public function setCouponDTOBuilder(CouponDTOBuilder $couponDTOBuilder): void
    {
        $this->couponDTOBuilder = $couponDTOBuilder;
    }
}
