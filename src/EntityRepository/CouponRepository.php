<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class CouponRepository extends AbstractRepository implements CouponRepositoryInterface
{
    public function findOneByCode($couponCode)
    {
        $coupon = parent::findOneBy(['code' => $couponCode]);

        if ($coupon === null) {
            throw $this->getEntityNotFoundException();
        }

        return $coupon;
    }

    public function getAllCoupons($queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('coupon')
            ->from('kommerce:coupon', 'coupon');

        if ($queryString !== null) {
            $query
                ->where('coupon.name LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getAllCouponsByIds($couponIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('coupon')
            ->from('kommerce:Coupon', 'coupon')
            ->where('coupon.id IN (:couponIds)')
            ->setParameter('couponIds', $couponIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
