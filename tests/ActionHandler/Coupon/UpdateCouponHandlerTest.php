<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\UpdateCouponCommand;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateCouponHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Coupon::class,
    ];

    public function testHandle()
    {
        $coupon1 = $this->dummyData->getCoupon();
        $this->persistEntityAndFlushClear($coupon1);
        $code = 'XXX';
        $flagFreeShipping = false;
        $minOrderValue = null;
        $maxOrderValue = null;
        $canCombineWithOtherCoupons = false;
        $name = '50% OFF Everything';
        $promotionTypeSlug = PromotionType::percent()->getSlug();
        $value = 50;
        $reducesTaxSubtotal = true;
        $startAt = self::FAKE_TIMESTAMP;
        $endAt = self::FAKE_TIMESTAMP;
        $maxRedemptions = 100;
        $command = new UpdateCouponCommand(
            $code,
            $flagFreeShipping,
            $minOrderValue,
            $maxOrderValue,
            $canCombineWithOtherCoupons,
            $name,
            $promotionTypeSlug,
            $value,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startAt,
            $endAt,
            $coupon1->getId()->toString()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $coupon = $this->getRepositoryFactory()->getCouponRepository()->findOneById(
            $command->getCouponId()
        );
        $this->assertSame($code, $coupon->getCode());
        $this->assertSame($flagFreeShipping, $coupon->getFlagFreeShipping());
        $this->assertSame($minOrderValue, $coupon->getMinOrderValue());
        $this->assertSame($maxOrderValue, $coupon->getMaxOrderValue());
        $this->assertSame($canCombineWithOtherCoupons, $coupon->getCanCombineWithOtherCoupons());
        $this->assertSame($name, $coupon->getName());
        $this->assertSame($promotionTypeSlug, $coupon->getType()->getSlug());
        $this->assertSame($value, $coupon->getValue());
        $this->assertSame($reducesTaxSubtotal, $coupon->getReducesTaxSubtotal());
        $this->assertSame($maxRedemptions, $coupon->getMaxRedemptions());
        $this->assertSame($startAt, $coupon->getStartAt());
        $this->assertSame($endAt, $coupon->getEndAt());
    }
}
