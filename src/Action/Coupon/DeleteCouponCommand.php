<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteCouponCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $couponId;

    /**
     * @param string $couponIdString
     */
    public function __construct($couponIdString)
    {
        $this->couponId = Uuid::fromString($couponIdString);
    }

    public function getCouponId()
    {
        return $this->couponId;
    }
}
