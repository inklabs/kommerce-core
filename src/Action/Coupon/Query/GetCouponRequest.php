<?php
namespace inklabs\kommerce\Action\Coupon\Query;

use Ramsey\Uuid\UuidInterface;

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
