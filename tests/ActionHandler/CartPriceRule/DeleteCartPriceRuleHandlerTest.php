<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCartPriceRuleHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $cartPriceRuleService = $this->mockService->getCartPriceRuleService();
        $cartPriceRuleService->shouldReceive('delete')
            ->once();

        $command = new DeleteCartPriceRuleCommand($cartPriceRule->getId()->getHex());
        $handler = new DeleteCartPriceRuleHandler($cartPriceRuleService);
        $handler->handle($command);
    }
}
