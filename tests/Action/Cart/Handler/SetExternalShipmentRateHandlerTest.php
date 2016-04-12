<?php
namespace inklabs\kommerce\Action\Cart\Handler;

use inklabs\kommerce\Action\Cart\SetExternalShipmentRateCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetExternalShipmentRateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('setExternalShipmentRate')
            ->once();

        $cartId = 1;
        $shipmentRateExternalId = 'shp_xxxxxxxx';
        $orderAddressDTO = $this->dummyData->getOrderAddress()
            ->getDTOBuilder()
            ->build();

        $command = new SetExternalShipmentRateCommand(
            $cartId,
            $shipmentRateExternalId,
            $orderAddressDTO
        );

        $handler = new SetExternalShipmentRateHandler($cartService);
        $handler->handle($command);
    }
}
