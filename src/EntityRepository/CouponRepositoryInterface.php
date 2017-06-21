<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Coupon findOneById(UuidInterface $id)
 */
interface CouponRepositoryInterface extends RepositoryInterface
{
    public function findOneByCode(string $couponCode): Coupon;

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCoupons(string $queryString = null, Pagination & $pagination = null);

    /**
     * @param UuidInterface[] $couponIds
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCouponsByIds(array $couponIds, Pagination & $pagination = null);
}
