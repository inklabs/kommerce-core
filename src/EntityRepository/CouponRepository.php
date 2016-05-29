<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Coupon;
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
            ->select('Coupon')
            ->from(Coupon::class, 'Coupon');

        if ($queryString !== null) {
            $query
                ->orWhere('Coupon.name LIKE :query')
                ->orWhere('Coupon.code LIKE :query')
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
            ->select('Coupon')
            ->from(Coupon::class, 'Coupon')
            ->where('Coupon.id IN (:couponIds)')
            ->setIdParameter('couponIds', $couponIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
