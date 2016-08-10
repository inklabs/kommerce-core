<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use DateTime;
use inklabs\kommerce\Action\Coupon\CreateCouponCommand;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCouponHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $couponService = $this->mockService->getCouponService();
        $couponService->shouldReceive('create')
            ->once();

        $code = 'XXX';
        $name = '50% OFF Everything';
        $promotionTypeId = PromotionType::PERCENT;
        $value = 50;
        $reducesTaxSubtotal = true;
        $startDate = new DateTime();
        $endDate = new DateTime();
        $maxRedemptions = 100;

        $command = new CreateCouponCommand(
            $code,
            false,
            null,
            null,
            false,
            $name,
            $promotionTypeId,
            $value,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startDate,
            $endDate
        );
        $handler = new CreateCouponHandler($couponService);
        $handler->handle($command);
    }
}
