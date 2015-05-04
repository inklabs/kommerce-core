<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class CouponTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Coupon',
    ];

    /** @var CouponInterface */
    protected $couponRepository;

    public function setUp()
    {
        $this->couponRepository = $this->repository()->getCoupon();
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

        $coupon = $this->couponRepository->find(1);

        $this->assertTrue($coupon instanceof Entity\Coupon);
    }

    public function testFindOneByCode()
    {
        $this->setupCoupon();

        $coupon = $this->couponRepository->findOneByCode('20PCT1');

        $this->assertTrue($coupon instanceof Entity\Coupon);
    }

    public function testGetAllCoupons()
    {
        $this->setupCoupon();

        $coupons = $this->couponRepository->getAllCoupons('Test');

        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }

    public function testGetAllCouponsByIds()
    {
        $this->setupCoupon();

        $coupons = $this->couponRepository->getAllCouponsByIds([1]);

        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }

    public function testCreate()
    {
        $coupon = $this->getDummyCoupon(1);

        $this->assertSame(null, $coupon->getId());
        $this->couponRepository->create($coupon);
        $this->assertSame(1, $coupon->getId());
    }

    public function testSave()
    {
        $coupon = $this->getDummyCoupon(1);

        $couponRepository = $this->couponRepository;
        $couponRepository->create($coupon);

        $coupon->setName('new name');
        $this->assertSame(null, $coupon->getUpdated());
        $couponRepository->save($coupon);
        $this->assertTrue($coupon->getUpdated() instanceof \DateTime);
    }
}
