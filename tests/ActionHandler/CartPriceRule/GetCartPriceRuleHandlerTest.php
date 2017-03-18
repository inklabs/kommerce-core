<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\GetCartPriceRuleQuery;
use inklabs\kommerce\ActionResponse\CartPriceRule\GetCartPriceRuleResponse;
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
        $query = new GetCartPriceRuleQuery($cartPriceRule->getId()->getHex());

        /** @var GetCartPriceRuleResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($cartPriceRule->getId(), $response->getCartPriceRuleDTO()->id);
    }
}
