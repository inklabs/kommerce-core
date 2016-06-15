<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartBySessionIdQuery;
use inklabs\kommerce\Action\Cart\Query\GetCartBySessionIdRequest;
use inklabs\kommerce\Action\Cart\Query\GetCartBySessionIdResponse;
use inklabs\kommerce\EntityDTO\CartDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCartBySessionIdHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartCalculator = $this->dummyData->getCartCalculator();
        $cartService = $this->mockService->getCartService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetCartBySessionIdRequest(self::UUID_HEX);
        $response = new GetCartBySessionIdResponse($cartCalculator);

        $handler = new GetCartBySessionIdHandler($cartService, $dtoBuilderFactory);

        $handler->handle(new GetCartBySessionIdQuery($request, $response));
        $this->assertTrue($response->getCartDTO() instanceof CartDTO);
    }
}
