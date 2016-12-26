<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\ListCartPriceRulesQuery;
use inklabs\kommerce\Action\CartPriceRule\Query\ListCartPriceRulesRequest;
use inklabs\kommerce\Action\CartPriceRule\Query\ListCartPriceRulesResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListCartPriceRulesHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartPriceRuleService = $this->mockService->getCartPriceRuleService();

        $queryString = 'PCT';
        $request = new ListCartPriceRulesRequest($queryString, new PaginationDTO);
        $response = new ListCartPriceRulesResponse;

        $handler = new ListCartPriceRulesHandler($cartPriceRuleService, $this->getDTOBuilderFactory());
        $handler->handle(new ListCartPriceRulesQuery($request, $response));

        $this->assertTrue($response->getCartPriceRuleDTOs()[0] instanceof CartPriceRuleDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
