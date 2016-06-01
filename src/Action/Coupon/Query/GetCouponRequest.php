<?php
namespace inklabs\kommerce\Action\Coupon\Query;

use inklabs\kommerce\Lib\UuidInterface;

final class GetCouponRequest
{
    /** @var UuidInterface */
    private $couponId;

    public function __construct(UuidInterface $couponId)
    {
        $this->couponId = $couponId;
    }

    public function getCouponId()
    {
        return $this->couponId;
    }
}
