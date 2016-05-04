<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Lib\Query\RequestInterface;

final class GetCouponRequest implements RequestInterface
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
