<?php
namespace inklabs\kommerce\Action\Coupon\Response;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CouponDTO;

class ListCouponsResponse implements ListCouponsResponseInterface
{
    /** @var CouponDTO[] */
    protected $couponDTOs = [];

    /** @var PaginationDTO */
    protected $paginationDTO;

    public function addCouponDTO(CouponDTO $couponDTO)
    {
        $this->couponDTOs[] = $couponDTO;
    }

    public function getCouponDTOs()
    {
        return $this->couponDTOs;
    }

    public function setPaginationDTO(PaginationDTO $paginationDTO)
    {
        $this->paginationDTO = $paginationDTO;
    }

    public function getPaginationDTO()
    {
        return $this->paginationDTO;
    }
}
