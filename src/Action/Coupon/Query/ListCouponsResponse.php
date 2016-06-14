<?php
namespace inklabs\kommerce\Action\Coupon\Query;

use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\EntityDTO\PaginationDTO;

class ListCouponsResponse implements ListCouponsResponseInterface
{
    /** @var CouponDTOBuilder[] */
    protected $couponDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    protected $paginationDTOBuilder;

    public function addCouponDTOBuilder(CouponDTOBuilder $couponDTOBuilder)
    {
        $this->couponDTOBuilders[] = $couponDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return CouponDTO[] | \Generator
     */
    public function getCouponDTOs()
    {
        $couponDTOs = [];
        foreach ($this->couponDTOBuilders as $couponDTOBuilder) {
            $couponDTOs[] = $couponDTOBuilder->build();
        }
        return $couponDTOs;
    }

    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
