<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberEntityInterface;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class CouponRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Coupon::class,
    ];

    /** @var CouponRepositoryInterface */
    protected $couponRepository;

    public function setUp()
    {
        parent::setUp();
        $this->couponRepository = $this->getRepositoryFactory()->getCouponRepository();
    }

    private function setupCoupon()
    {
        $coupon = $this->dummyData->getCoupon();
        $this->persistEntityAndFlushClear($coupon);
    }

    public function testSave()
    {
        $coupon = $this->dummyData->getCoupon(1);

        $couponRepository = $this->couponRepository;
        $couponRepository->create($coupon);

        $coupon->setName('new name');
        $this->assertSame(null, $coupon->getUpdated());
        $couponRepository->update($coupon);
        $this->assertTrue($coupon->getUpdated() instanceof DateTime);

        $this->couponRepository->delete($coupon);
        $this->assertSame(null, $coupon->getId());
    }

    public function testFind()
    {
        $code = '20PCT';
        $name = '20% Off orders over $100';
        $value = 20;
        $minOrderValue = 10000;
        $maxOrderValue = 100000;
        $promotionType = PromotionType::fixed();

        $coupon = new Coupon($code);
        $coupon->setName($name);
        $coupon->setValue($value);
        $coupon->setType($promotionType);
        $coupon->setMinOrderValue($minOrderValue);
        $coupon->setMaxOrderValue($maxOrderValue);
        $coupon->setFlagFreeShipping(true);
        $coupon->setCanCombineWithOtherCoupons(true);

        $this->persistEntityAndFlushClear($coupon);

        $this->setCountLogger();

        $coupon = $this->couponRepository->findOneById(1);

        $this->assertTrue($coupon instanceof Coupon);
        $this->assertSame($code, $coupon->getCode());
        $this->assertSame($name, $coupon->getName());
        $this->assertSame($value, $coupon->getValue());
        $this->assertSame($minOrderValue, $coupon->getMinOrderValue());
        $this->assertSame($maxOrderValue, $coupon->getMaxOrderValue());
        $this->assertTrue($coupon->getType()->isFixed());
        $this->assertTrue($coupon->getFlagFreeShipping());
        $this->assertTrue($coupon->getCanCombineWithOtherCoupons());
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindOneByCode()
    {
        $this->setupCoupon();
        $coupon = $this->couponRepository->findOneByCode('20PCT1');
        $this->assertTrue($coupon instanceof Coupon);
    }

    public function testFindOneByCodeMissingThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Coupon not found'
        );

        $this->couponRepository->findOneByCode('20PCT1');
    }

    public function testGetAllCoupons()
    {
        $this->setupCoupon();
        $coupons = $this->couponRepository->getAllCoupons('Test');
        $this->assertTrue($coupons[0] instanceof Coupon);
    }

    public function testGetAllCouponsByIds()
    {
        $this->setupCoupon();
        $coupons = $this->couponRepository->getAllCouponsByIds([1]);
        $this->assertTrue($coupons[0] instanceof Coupon);
    }

    public function testCreate()
    {
        $coupon = $this->dummyData->getCoupon(1);

        $this->assertSame(null, $coupon->getId());
        $this->couponRepository->create($coupon);
        $this->assertSame(1, $coupon->getId());
    }
}
