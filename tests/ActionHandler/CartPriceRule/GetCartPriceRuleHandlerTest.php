<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\GetCartPriceRuleQuery;
use inklabs\kommerce\Action\CartPriceRule\Query\GetCartPriceRuleRequest;
use inklabs\kommerce\Action\CartPriceRule\Query\GetCartPriceRuleResponse;
use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCartPriceRuleHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $coupon = $this->dummyData->getCartPriceRule();
        $couponService = $this->mockService->getCartPriceRuleService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetCartPriceRuleRequest($coupon->getId()->getHex());
        $response = new GetCartPriceRuleResponse;

        $handler = new GetCartPriceRuleHandler($couponService, $dtoBuilderFactory);
        $handler->handle(new GetCartPriceRuleQuery($request, $response));

        $this->assertTrue($response->getCartPriceRuleDTO() instanceof CartPriceRuleDTO);
    }
}
