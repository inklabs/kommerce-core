<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class Coupon extends AbstractEntityRepository implements CouponInterface
{
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
