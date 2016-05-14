<?php
namespace inklabs\kommerce\Action\Coupon\Query;

final class GetCouponRequest
{
    /** @var int */
    private $couponId;

    /**
     * @param int $couponId
     */
    public function __construct($couponId)
    {
        $this->couponId = (int) $couponId;
    }

    public function getCouponId()
    {
        return $this->couponId;
    }
}
