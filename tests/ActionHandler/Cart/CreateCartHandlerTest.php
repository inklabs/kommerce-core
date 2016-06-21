<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\CreateCartCommand;
use inklabs\kommerce\Lib\UuidInterface;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCartHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('create')
            ->once();

        $command = new CreateCartCommand(
            self::IP4,
            self::UUID_HEX,
            self::SESSION_ID
        );
        $handler = new CreateCartHandler($cartService);
        $handler->handle($command);

        $this->assertTrue($command->getCartId() instanceof UuidInterface);
    }
}
