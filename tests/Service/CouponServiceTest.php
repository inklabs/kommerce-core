<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCouponRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class CouponServiceTest extends ServiceTestCase
{
    /** @var CouponRepositoryInterface|\Mockery\Mock */
    protected $couponRepository;

    /** @var CouponService */
    protected $couponService;

    public function setUp()
    {
        parent::setUp();

        $this->couponRepository = $this->mockRepository->getCouponRepository();
        $this->couponService = new CouponService($this->couponRepository);
    }

    public function testFindOnceById()
    {
        $coupon1 = $this->dummyData->getCoupon();

        $this->couponRepository->shouldReceive('findOneById')
            ->with($coupon1->getId())
            ->andReturn($coupon1)
            ->once();

        $coupon = $this->couponService->findOneById($coupon1->getId());

        $this->assertSame($coupon1, $coupon);
    }

    public function testGetAllCoupons()
    {
        $coupon1 = $this->dummyData->getCoupon();

        $this->couponRepository->shouldReceive('getAllCoupons')
            ->andReturn($coupon1)
            ->once();

        $coupon = $this->couponService->getAllCoupons();

        $this->assertSame($coupon1, $coupon);
    }

    public function testAllGetCouponsByIds()
    {
        $coupon1 = $this->dummyData->getCoupon();

        $this->couponRepository->shouldReceive('getAllCouponsByIds')
            ->with([$coupon1->getId()], null)
            ->andReturn([$coupon1])
            ->once();

        $coupons = $this->couponService->getAllCouponsByIds([
            $coupon1->getId()
        ]);

        $this->assertSame($coupon1, $coupons[0]);
    }
}
