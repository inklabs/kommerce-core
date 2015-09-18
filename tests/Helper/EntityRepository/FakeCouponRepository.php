<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\Entity;

class FakeCouponRepository extends AbstractFakeRepository implements CouponRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Coupon);
    }

    public function save(Entity\Coupon & $coupon)
    {
    }

    public function create(Entity\Coupon & $coupon)
    {
    }

    public function remove(Entity\Coupon & $coupon)
    {
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findOneByCode($couponCode)
    {
        return $this->getReturnValue();
    }

    public function getAllCoupons($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllCouponsByIds($couponIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
