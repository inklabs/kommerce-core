<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\UpdateCartPriceRuleCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateCartPriceRuleHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartPriceRuleService = $this->mockService->getCartPriceRuleService();
        $cartPriceRuleService->shouldReceive('update')
            ->once();

        $cartPriceRuleDTO = $this->getDTOBuilderFactory()
            ->getCartPriceRuleDTOBuilder($this->dummyData->getCartPriceRule())
            ->build();

        $command = new UpdateCartPriceRuleCommand($cartPriceRuleDTO);
        $handler = new UpdateCartPriceRuleHandler($cartPriceRuleService);
        $handler->handle($command);
    }
}
