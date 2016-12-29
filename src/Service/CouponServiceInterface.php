<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface CouponServiceInterface
{
    /**
     * @param UuidInterface $id
     * @return Coupon
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCoupons($queryString = null, Pagination & $pagination = null);

    /**
     * @param UuidInterface[] $couponIds
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCouponsByIds($couponIds, Pagination & $pagination = null);
}
