<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCouponRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class CouponServiceTest extends ServiceTestCase
{
    /** @var FakeCouponRepository */
    protected $couponRepository;

    /** @var CouponService */
    protected $couponService;

    public function setUp()
    {
        parent::setUp();

        $this->couponRepository = new FakeCouponRepository;
        $this->couponService = new CouponService($this->couponRepository);
    }

    public function testCreate()
    {
        $coupon = $this->dummyData->getCoupon();

        $this->couponService->create($coupon);

        $coupon = $this->couponRepository->findOneById(1);
        $this->assertTrue($coupon instanceof Coupon);
    }

    public function testUpdate()
    {
        $newName = 'New Name';
        $coupon = $this->dummyData->getCoupon();
        $this->couponRepository->create($coupon);

        $this->assertNotSame($newName, $coupon->getName());
        $coupon->setName($newName);

        $this->couponService->update($coupon);

        $coupon = $this->couponRepository->findOneById(1);
        $this->assertSame($newName, $coupon->getName());
    }

    public function testDelete()
    {
        $coupon = $this->dummyData->getCoupon();
        $this->couponRepository->create($coupon);

        $this->couponService->delete($coupon);

        $this->setExpectedException(
            EntityNotFoundException::class,
            'Coupon not found'
        );
        $this->couponRepository->findOneById(1);
    }

    public function testFind()
    {
        $coupon = $this->dummyData->getCoupon();
        $this->couponRepository->create($coupon);

        $coupon = $this->couponService->findOneById(1);
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
