<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\DeleteCartItemCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCartItemHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('deleteItem')
            ->once();

        $cartId = self::UUID_HEX;

        $command = new DeleteCartItemCommand($cartId);
        $handler = new DeleteCartItemHandler($cartService);
        $handler->handle($command);
    }
}
