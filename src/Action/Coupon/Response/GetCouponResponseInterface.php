<?php
namespace inklabs\kommerce\Action\Coupon\Response;

use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

interface GetCouponResponseInterface extends ResponseInterface
{
    public function setCouponDTO(CouponDTO $couponDTO);
}
