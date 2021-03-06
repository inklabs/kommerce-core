<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCouponQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $couponId;

    public function __construct(string $couponId)
    {
        $this->couponId = Uuid::fromString($couponId);
    }

    public function getCouponId(): UuidInterface
    {
        return $this->couponId;
    }
}
