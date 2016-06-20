<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\AddCouponToCartCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddCouponToCartHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('addCouponByCode')
            ->once();

        $command = new AddCouponToCartCommand(
            self::UUID_HEX,
            self::COUPON_CODE
        );

        $handler = new AddCouponToCartHandler($cartService);
        $handler->handle($command);
    }
}
