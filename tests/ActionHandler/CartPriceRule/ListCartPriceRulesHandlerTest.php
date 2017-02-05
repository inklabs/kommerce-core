<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\ListCartPriceRulesQuery;
use inklabs\kommerce\Action\CartPriceRule\Query\ListCartPriceRulesRequest;
use inklabs\kommerce\Action\CartPriceRule\Query\ListCartPriceRulesResponse;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListCartPriceRulesHandlerTest extends ActionTestCase
{
     protected $metaDataClassNames = [
        CartPriceRule::class,
     ];

    public function testHandle()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $this->persistEntityAndFlushClear($cartPriceRule);
        $queryString = 'Rule';
        $request = new ListCartPriceRulesRequest($queryString, new PaginationDTO());
        $response = new ListCartPriceRulesResponse();
        $query = new ListCartPriceRulesQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertTrue($response->getCartPriceRuleDTOs()[0] instanceof CartPriceRuleDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
