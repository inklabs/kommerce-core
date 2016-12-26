<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use DateTime;
use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCartPriceRuleHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $couponService = $this->mockService->getCartPriceRuleService();
        $couponService->shouldReceive('create')
            ->once();

        $name = '50% OFF Everything';
        $reducesTaxSubtotal = true;
        $maxRedemptions = 100;
        $startDate = new DateTime();
        $endDate = new DateTime();

        $command = new CreateCartPriceRuleCommand(
            $name,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startDate,
            $endDate
        );
        $handler = new CreateCartPriceRuleHandler($couponService);
        $handler->handle($command);
    }
}
