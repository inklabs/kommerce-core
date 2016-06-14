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
        return $coupon;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->couponRepository,
            $this->dummyData->getCoupon()
        );
    }

    public function testFind()
    {
        $code = '20PCT';
        $name = '20% Off orders over $100';
        $value = 20;
        $minOrderValue = 10000;
        $maxOrderValue = 100000;
        $promotionType = PromotionType::fixed();

        $originalCoupon = new Coupon($code);
        $originalCoupon->setName($name);
        $originalCoupon->setValue($value);
        $originalCoupon->setType($promotionType);
        $originalCoupon->setMinOrderValue($minOrderValue);
        $originalCoupon->setMaxOrderValue($maxOrderValue);
        $originalCoupon->setFlagFreeShipping(true);
        $originalCoupon->setCanCombineWithOtherCoupons(true);
        $this->persistEntityAndFlushClear($originalCoupon);
        $this->setCountLogger();

        $coupon = $this->couponRepository->findOneById($originalCoupon->getId());

        $this->assertEquals($originalCoupon->getId(), $coupon->getId());
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
        $originalCoupon = $this->dummyData->getCoupon();
        $originalCoupon->setCode('xyz');
        $this->persistEntityAndFlushClear($originalCoupon);

        $coupon = $this->couponRepository->findOneByCode('xyz');

        $this->assertEquals($originalCoupon->getId(), $coupon->getId());
    }

    public function testFindOneByCodeMissingThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Coupon not found'
        );

        $this->couponRepository->findOneByCode('xyz');
    }

    public function testGetAllCoupons()
    {
        $originalCoupon = $this->setupCoupon();

        $coupons = $this->couponRepository->getAllCoupons(
            $originalCoupon->getName()
        );

        $this->assertEquals($originalCoupon->getId(), $coupons[0]->getId());
    }

    public function testGetAllCouponsByIds()
    {
        $originalCoupon = $this->setupCoupon();

        $coupons = $this->couponRepository->getAllCouponsByIds([
            $originalCoupon->getId()
        ]);

        $this->assertEquals($originalCoupon->getId(), $coupons[0]->getId());
    }
}
