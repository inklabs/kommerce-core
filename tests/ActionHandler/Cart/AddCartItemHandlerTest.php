<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\AddCartItemCommand;
use inklabs\kommerce\InputDTO\TextOptionValueDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddCartItemHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService
            ->shouldReceive('addItem')
            ->andReturn($this->dummyData->getCartItem())
            ->once();

        $cartId = self::UUID_HEX;
        $productId = self::UUID_HEX;
        $quantity = 2;

        $command = new AddCartItemCommand(
            $cartId,
            $productId,
            $quantity
        );

        $handler = new AddCartItemHandler($cartService);
        $handler->handle($command);
    }

    public function testHandleFull()
    {
        $cartService = $this->mockService->getCartService();
        $cartService
            ->shouldReceive('addItem')
            ->andReturn($this->dummyData->getCartItem())
            ->once();

        $cartService->shouldReceive('addItemOptionProducts')->once();
        $cartService->shouldReceive('addItemOptionValues')->once();
        $cartService->shouldReceive('addItemTextOptionValues')->once();

        $cartId = self::UUID_HEX;
        $productId = self::UUID_HEX;
        $quantity = 2;

        $optionProductIds = [self::UUID_HEX];
        $optionValueIds = [self::UUID_HEX];
        $textOptionValueDTOs = [
            new TextOptionValueDTO(
                self::UUID_HEX,
                'Happy Birthday'
            )
        ];

        $command = new AddCartItemCommand(
            $cartId,
            $productId,
            $quantity,
            $optionProductIds,
            $optionValueIds,
            $textOptionValueDTOs
        );

        $handler = new AddCartItemHandler($cartService);
        $handler->handle($command);
    }
}
