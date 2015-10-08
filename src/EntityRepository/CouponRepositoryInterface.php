<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Pagination;

/**
 * @method Coupon find($id)
 */
interface CouponRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $couponCode
     * @return Coupon
     */
    public function findOneByCode($couponCode);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCoupons($queryString = null, Pagination & $pagination = null);

    /**
     * @param int[] $couponIds
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCouponsByIds($couponIds, Pagination & $pagination = null);
}
