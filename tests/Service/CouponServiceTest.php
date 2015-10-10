<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCouponRepository;

class CouponServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeCouponRepository */
    protected $couponRepository;

    /** @var CouponService */
    protected $couponService;

    public function setUp()
    {
        $this->couponRepository = new FakeCouponRepository;
        $this->couponService = new CouponService($this->couponRepository);
    }

    public function testCreate()
    {
        $coupon = $this->getDummyCoupon();
        $this->couponService->create($coupon);
        $this->assertTrue($coupon instanceof Coupon);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $coupon = $this->getDummyCoupon();
        $this->assertNotSame($newName, $coupon->getName());

        $coupon->setName($newName);
        $this->couponService->edit($coupon);
        $this->assertSame($newName, $coupon->getName());
    }

    public function testFind()
    {
        $coupon = $this->couponService->find(1);
        $this->assertTrue($coupon instanceof Coupon);
    }

    public function testGetAllCoupons()
    {
        $coupons = $this->couponService->getAllCoupons();
        $this->assertTrue($coupons[0] instanceof Coupon);
    }

    public function testAllGetCouponsByIds()
    {
        $coupons = $this->couponService->getAllCouponsByIds([1]);
        $this->assertTrue($coupons[0] instanceof Coupon);
    }
}
