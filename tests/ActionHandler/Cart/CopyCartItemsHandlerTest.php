<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\CopyCartItemsCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CopyCartItemsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('copyCartItems')
            ->once();

        $cartId = self::UUID_HEX;
        $userId = self::UUID_HEX;

        $command = new CopyCartItemsCommand(
            $cartId,
            $userId
        );

        $handler = new CopyCartItemsHandler($cartService);
        $handler->handle($command);
    }
}
