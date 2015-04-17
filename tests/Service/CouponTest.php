<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class CouponTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\Coupon */
    protected $mockCouponRepository;

    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    /** @var Coupon */
    protected $couponService;

    /** @var Entity\Coupon */
    protected $coupon;

    protected $metaDataClassNames = [
        'kommerce:Coupon',
    ];

    public function setUp()
    {
        $this->mockCouponRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Coupon');
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $this->couponService = new Coupon($this->entityManager);
    }

    private function setupCoupon()
    {
        $this->coupon = new Entity\Coupon;
        $this->coupon->setName('20% OFF Test');
        $this->coupon->setCode('20PCT');
        $this->coupon->setType(Entity\Promotion::TYPE_PERCENT);
        $this->coupon->setValue(20);

        $this->entityManager->persist($this->coupon);
        $this->entityManager->flush();
    }

    public function testFindMissing()
    {
        $coupon = $this->couponService->find(0);
        $this->assertSame(null, $coupon);
    }

    public function testFind()
    {
        $this->setupCoupon();
        $this->entityManager->clear();

        $coupon = $this->couponService->find(1);
        $this->assertSame(1, $coupon->id);
    }

    public function testGetAllCoupons()
    {
        $this->mockCouponRepository
            ->shouldReceive('getAllCoupons')
            ->andReturn([new Entity\Coupon]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockCouponRepository);

        $couponService = new Coupon($this->mockEntityManager);

        $coupons = $couponService->getAllCoupons();
        $this->assertTrue($coupons[0] instanceof View\Coupon);
    }

    public function testAllGetCouponsByIds()
    {
        $this->mockCouponRepository
            ->shouldReceive('getAllCouponsByIds')
            ->andReturn([new Entity\Coupon]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockCouponRepository);

        $couponService = new Coupon($this->mockEntityManager);

        $coupons = $couponService->getAllCouponsByIds([1]);
        $this->assertTrue($coupons[0] instanceof View\Coupon);
    }
}
