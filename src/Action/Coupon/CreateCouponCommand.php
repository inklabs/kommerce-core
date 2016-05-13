<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class CreateCouponCommand implements CommandInterface
{
    /** @var CouponDTO */
    private $couponDTO;

    public function __construct(CouponDTO $couponDTO)
    {
        $this->couponDTO = $couponDTO;
    }

    public function getCouponDTO()
    {
        return $this->couponDTO;
    }
}
