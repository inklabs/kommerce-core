<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\AddCartItemCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddCartItemHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('addItem')
            ->once();

        $command = new AddCartItemCommand(
            self::UUID_HEX,
            self::UUID_HEX,
            2
        );

        $handler = new AddCartItemHandler($cartService);
        $handler->handle($command);
    }
}
