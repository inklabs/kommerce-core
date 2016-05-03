<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\tests\Helper\Entity\DummyData;

/**
 * @method Coupon findOneById($id)
 */
class FakeCouponRepository extends FakeRepository implements CouponRepositoryInterface
{
    protected $entityName = 'Coupon';

    /** @var Coupon[] */
    protected $entities = [];

    public function __construct()
    {
        $dummyData = new DummyData();
        $coupon = $dummyData->getCoupon();
        $this->setReturnValue($coupon);
    }

    public function findOneByCode($couponCode)
    {
        foreach ($this->entities as $entity) {
            if ($entity->getCode() === $couponCode) {
                return $entity;
            }
        }

        throw $this->getEntityNotFoundException();
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
