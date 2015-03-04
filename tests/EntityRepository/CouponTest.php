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

    public function testFind()
    {
        $coupon1 = $this->getDummyCoupon(1);

        $this->entityManager->persist($coupon1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $coupon = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $coupon->getId());
    }

    public function testGetAllCoupons()
    {
        $coupon1 = $this->getDummyCoupon(1);

        $this->entityManager->persist($coupon1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $coupons = $this->getRepository()
            ->getAllCoupons('Test');

        $this->assertSame(1, $coupons[0]->getId());
    }

    public function testGetAllCouponsByIds()
    {
        $coupon1 = $this->getDummyCoupon(1);

        $this->entityManager->persist($coupon1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $coupons = $this->getRepository()
            ->getAllCouponsByIds([1]);

        $this->assertSame(1, $coupons[0]->getId());
    }
}
