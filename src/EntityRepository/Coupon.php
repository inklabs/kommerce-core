<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

/**
 * @method Entity\Coupon find($id)
 */
class Coupon extends AbstractEntityRepository
{
    /**
     * @return Entity\Coupon[]
     */
    public function getAllCoupons($queryString = null, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $coupons = $qb->select('coupon')
            ->from('kommerce:coupon', 'coupon');

        if ($queryString !== null) {
            $coupons = $coupons
                ->where('coupon.name LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        $coupons = $coupons
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $coupons;
    }

    /**
     * @return Entity\Coupon[]
     */
    public function getAllCouponsByIds($couponIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $coupons = $qb->select('coupon')
            ->from('kommerce:Coupon', 'coupon')
            ->where('coupon.id IN (:couponIds)')
            ->setParameter('couponIds', $couponIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $coupons;
    }
}
