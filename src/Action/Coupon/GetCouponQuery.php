<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCouponQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $couponId;

    /**
     * @param string $couponId
     */
    public function __construct($couponId)
    {
        $this->couponId = Uuid::fromString($couponId);
    }

    public function getCouponId()
    {
        return $this->couponId;
    }
}
