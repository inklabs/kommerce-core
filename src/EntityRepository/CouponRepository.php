<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class CouponRepository extends AbstractRepository implements CouponRepositoryInterface
{
    public function findOneByCode($couponCode)
    {
        return parent::findOneBy(['code' => $couponCode]);
    }

    public function getAllCoupons($queryString = null, Pagination & $pagination = null)
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

    public function getAllCouponsByIds($couponIds, Pagination & $pagination = null)
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
