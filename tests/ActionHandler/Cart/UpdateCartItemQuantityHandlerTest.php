<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\UpdateCartItemQuantityCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateCartItemQuantityHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('updateItemQuantity')
            ->once();

        $command = new UpdateCartItemQuantityCommand(
            self::UUID_HEX,
            2
        );

        $handler = new UpdateCartItemQuantityHandler($cartService);
        $handler->handle($command);
    }
}
