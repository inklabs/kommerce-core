<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\RemoveCartCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveCartHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('removeCart')
            ->once();

        $cartId = self::UUID_HEX;

        $command = new RemoveCartCommand($cartId);
        $handler = new RemoveCartHandler($cartService);
        $handler->handle($command);
    }
}
