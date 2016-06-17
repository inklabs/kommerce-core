<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartSessionIdCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetCartSessionIdHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('setSessionId')
            ->once();

        $cartId = self::UUID_HEX;
        $sessionId = self::SESSION_ID;

        $command = new SetCartSessionIdCommand(
            $cartId,
            $sessionId
        );

        $handler = new SetCartSessionIdHandler($cartService);
        $handler->handle($command);
    }
}
