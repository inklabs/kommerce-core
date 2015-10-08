<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;

class FakeCouponRepository extends AbstractFakeRepository implements CouponRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Coupon);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findOneByCode($couponCode)
    {
        return $this->getReturnValue();
    }

    public function getAllCoupons($queryString = null, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllCouponsByIds($couponIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
