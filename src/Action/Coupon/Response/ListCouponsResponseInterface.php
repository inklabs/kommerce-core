<?php
namespace inklabs\kommerce\Action\Coupon\Response;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

interface ListCouponsResponseInterface extends ResponseInterface
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
