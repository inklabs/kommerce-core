<?php
namespace inklabs\kommerce\ActionResponse\Coupon;

use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListCouponsResponse implements ResponseInterface
{
    /** @var CouponDTOBuilder[] */
    protected $couponDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    protected $paginationDTOBuilder;

    public function addCouponDTOBuilder(CouponDTOBuilder $couponDTOBuilder): void
    {
        $this->couponDTOBuilders[] = $couponDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return CouponDTO[]
     */
    public function getCouponDTOs(): array
    {
        $couponDTOs = [];
        foreach ($this->couponDTOBuilders as $couponDTOBuilder) {
            $couponDTOs[] = $couponDTOBuilder->build();
        }
        return $couponDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
