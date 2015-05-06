<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCoupon;

class CouponTest extends Helper\DoctrineTestCase
{
    /** @var FakeCoupon */
    protected $couponRepository;

    /** @var Coupon */
    protected $couponService;

    public function setUp()
    {
        $this->couponRepository = new FakeCoupon;
        $this->couponService = new Coupon($this->couponRepository);
    }

    public function testFind()
    {
        $coupon = $this->couponService->find(1);
        $this->assertTrue($coupon instanceof View\Coupon);
    }

    public function testFindMissing()
    {
        $this->couponRepository->setReturnValue(null);

        $coupon = $this->couponService->find(1);
        $this->assertSame(null, $coupon);
    }

    public function testGetAllCoupons()
    {
        $coupons = $this->couponService->getAllCoupons();
        $this->assertTrue($coupons[0] instanceof View\Coupon);
    }

    public function testAllGetCouponsByIds()
    {
        $coupons = $this->couponService->getAllCouponsByIds([1]);
        $this->assertTrue($coupons[0] instanceof View\Coupon);
    }
}
