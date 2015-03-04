<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class CouponTest extends Helper\DoctrineTestCase
{
    /* @var Entity\Coupon */
    protected $coupon;

    /**
     * @return Coupon
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Coupon');
    }

    /**
     * @return Entity\Coupon
     */
    private function getDummyCoupon($num)
    {
        $coupon = new Entity\Coupon;
        $coupon->setName('20% OFF Test ' . $num);
        $coupon->setCode('20PCT' . $num);
        $coupon->setType(Entity\Promotion::TYPE_PERCENT);
        $coupon->setValue(20);
        return $coupon;
    }

    private function setupCoupon()
    {
        $coupon1 = $this->getDummyCoupon(1);

        $this->entityManager->persist($coupon1);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupCoupon();

        $coupon = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $coupon->getId());
    }

    public function testGetAllCoupons()
    {
        $this->setupCoupon();

        $coupons = $this->getRepository()
            ->getAllCoupons('Test');

        $this->assertSame(1, $coupons[0]->getId());
    }

    public function testGetAllCouponsByIds()
    {
        $this->setupCoupon();

        $coupons = $this->getRepository()
            ->getAllCouponsByIds([1]);

        $this->assertSame(1, $coupons[0]->getId());
    }
}
