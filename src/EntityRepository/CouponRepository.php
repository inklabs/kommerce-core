<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Pagination;

class CouponRepository extends AbstractRepository implements CouponRepositoryInterface
{
    public function findOneByCode(string $couponCode): Coupon
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['code' => $couponCode])
        );
    }

    public function getAllCoupons(string $queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('Coupon')
            ->from(Coupon::class, 'Coupon');

        if (trim($queryString) !== '') {
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

    public function getAllCouponsByIds(array $couponIds, Pagination & $pagination = null)
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
