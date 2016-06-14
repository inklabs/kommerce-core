<?php
namespace inklabs\kommerce\Action\Coupon\Query;

use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;

interface ListCouponsResponseInterface
{
    public function addCouponDTOBuilder(CouponDTOBuilder $couponDTOBuilder);
    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder);
}
