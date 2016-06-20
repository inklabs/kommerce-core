<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\RemoveCouponFromCartCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveCouponFromCartHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('removeCoupon')
            ->once();

        $command = new RemoveCouponFromCartCommand(
            self::UUID_HEX,
            self::UUID_HEX
        );

        $handler = new RemoveCouponFromCartHandler($cartService);
        $handler->handle($command);
    }
}
