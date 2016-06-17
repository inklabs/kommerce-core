<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartUserCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetCartUserHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('setUserById')
            ->once();

        $cartId = self::UUID_HEX;
        $userId = self::UUID_HEX;

        $command = new SetCartUserCommand(
            $cartId,
            $userId
        );

        $handler = new SetCartUserHandler($cartService);
        $handler->handle($command);
    }
}
