<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeRepositoryCoupon;

class CouponTest extends Helper\DoctrineTestCase
{
    /** @var FakeRepositoryCoupon */
    protected $couponRepository;

    /** @var Coupon */
    protected $couponService;

    public function setUp()
    {
        $this->couponRepository = new FakeRepositoryCoupon;
        $this->couponService = new Coupon($this->couponRepository);
    }

    public function testCreate()
    {
        $coupon = $this->getDummyCoupon();
        $this->couponService->create($coupon);
        $this->assertTrue($coupon instanceof Entity\Coupon);
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
        $this->assertTrue($coupon instanceof Entity\Coupon);
    }

    public function testGetAllCoupons()
    {
        $coupons = $this->couponService->getAllCoupons();
        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }

    public function testAllGetCouponsByIds()
    {
        $coupons = $this->couponService->getAllCouponsByIds([1]);
        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }
}
