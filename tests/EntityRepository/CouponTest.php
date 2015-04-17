<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class CouponTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Coupon',
    ];

    /**
     * @return Coupon
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Coupon');
    }

    private function setupCoupon()
    {
        $coupon = $this->getDummyCoupon();

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupCoupon();

        $coupon = $this->getRepository()
            ->find(1);

        $this->assertTrue($coupon instanceof Entity\Coupon);
    }

    public function testGetAllCoupons()
    {
        $this->setupCoupon();

        $coupons = $this->getRepository()
            ->getAllCoupons('Test');

        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }

    public function testGetAllCouponsByIds()
    {
        $this->setupCoupon();

        $coupons = $this->getRepository()
            ->getAllCouponsByIds([1]);

        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }
}
