<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartFlatRateShipmentRateCommand;
use inklabs\kommerce\EntityDTO\MoneyDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetCartFlatRateShipmentRateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('setShipmentRate')
            ->once();

        $cartId = self::UUID_HEX;

        $moneyDTO = new MoneyDTO;
        $moneyDTO->amount = 100;
        $moneyDTO->currency = self::CURRENCY;

        $command = new SetCartFlatRateShipmentRateCommand(
            $cartId,
            $moneyDTO
        );

        $handler = new SetCartFlatRateShipmentRateHandler($cartService);
        $handler->handle($command);
    }
}
