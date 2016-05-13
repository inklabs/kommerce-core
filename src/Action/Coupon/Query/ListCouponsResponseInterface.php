<?php
namespace inklabs\kommerce\Action\Coupon\Query;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CouponDTO;

interface ListCouponsResponseInterface
{
    public function addCouponDTO(CouponDTO $couponDTO);
    public function setPaginationDTO(PaginationDTO $paginationDTO);

    /**
     * @return CouponDTO[]
     */
    public function getCouponDTOs();


    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO();
}
