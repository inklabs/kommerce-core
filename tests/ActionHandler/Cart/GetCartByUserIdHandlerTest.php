<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartByUserIdQuery;
use inklabs\kommerce\Action\Cart\Query\GetCartByUserIdRequest;
use inklabs\kommerce\Action\Cart\Query\GetCartByUserIdResponse;
use inklabs\kommerce\EntityDTO\CartDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCartByUserIdHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartCalculator = $this->dummyData->getCartCalculator();
        $cartService = $this->mockService->getCartService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetCartByUserIdRequest(self::UUID_HEX);
        $response = new GetCartByUserIdResponse($cartCalculator);

        $handler = new GetCartByUserIdHandler($cartService, $dtoBuilderFactory);

        $handler->handle(new GetCartByUserIdQuery($request, $response));
        $this->assertTrue($response->getCartDTO() instanceof CartDTO);
    }
}
