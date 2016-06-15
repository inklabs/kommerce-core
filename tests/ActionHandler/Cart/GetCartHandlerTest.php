<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartQuery;
use inklabs\kommerce\Action\Cart\Query\GetCartRequest;
use inklabs\kommerce\Action\Cart\Query\GetCartResponse;
use inklabs\kommerce\EntityDTO\CartDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCartHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartCalculator = $this->dummyData->getCartCalculator();
        $cartService = $this->mockService->getCartService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetCartRequest(self::UUID_HEX);
        $response = new GetCartResponse($cartCalculator);

        $handler = new GetCartHandler($cartService, $dtoBuilderFactory);

        $handler->handle(new GetCartQuery($request, $response));
        $this->assertTrue($response->getCartDTO() instanceof CartDTO);

        $handler->handle(new GetCartQuery($request, $response));
        $this->assertTrue($response->getCartDTOWithAllData() instanceof CartDTO);
    }
}
