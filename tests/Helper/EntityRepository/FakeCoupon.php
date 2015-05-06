<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\CouponInterface;
use inklabs\kommerce\Entity;

class FakeCoupon extends AbstractFake implements CouponInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Coupon);
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

    public function save(Entity\Coupon & $coupon)
    {
    }

    public function create(Entity\Coupon & $coupon)
    {
    }
}
