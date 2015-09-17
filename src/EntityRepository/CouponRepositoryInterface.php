<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CouponRepositoryInterface
{
    public function save(Entity\Coupon & $coupon);
    public function create(Entity\Coupon & $coupon);
    public function remove(Entity\Coupon & $coupon);

    /**
     * @param int $id
     * @return Entity\Coupon
     */
    public function find($id);

    /**
     * @param string $couponCode
     * @return Entity\Coupon
     */
    public function findOneByCode($couponCode);

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\Coupon[]
     */
    public function getAllCoupons($queryString = null, Entity\Pagination & $pagination = null);

    /**
     * @param int[] $couponIds
     * @param Entity\Pagination $pagination
     * @return Entity\Coupon[]
     */
    public function getAllCouponsByIds($couponIds, Entity\Pagination & $pagination = null);
}
