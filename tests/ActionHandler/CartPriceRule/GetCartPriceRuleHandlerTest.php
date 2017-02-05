<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\GetCartPriceRuleQuery;
use inklabs\kommerce\Action\CartPriceRule\Query\GetCartPriceRuleRequest;
use inklabs\kommerce\Action\CartPriceRule\Query\GetCartPriceRuleResponse;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCartPriceRuleHandlerTest extends ActionTestCase
{
     protected $metaDataClassNames = [
        CartPriceRule::class,
     ];

    public function testHandle()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $this->persistEntityAndFlushClear($cartPriceRule);
        $request = new GetCartPriceRuleRequest($cartPriceRule->getId()->getHex());
        $response = new GetCartPriceRuleResponse();
        $query = new GetCartPriceRuleQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertEquals($cartPriceRule->getId(), $response->getCartPriceRuleDTO()->id);
    }
}
