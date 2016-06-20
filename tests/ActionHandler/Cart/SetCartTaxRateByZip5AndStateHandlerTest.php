<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartTaxRateByZip5AndStateCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetCartTaxRateByZip5AndStateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $taxRateService = $this->mockService->getTaxRateService();
        $cartService = $this->mockService->getCartService();
        $cartService->shouldReceive('setTaxRate')
            ->once();

        $command = new SetCartTaxRateByZip5AndStateCommand(
            self::UUID_HEX,
            self::ZIP5,
            self::STATE
        );

        $handler = new SetCartTaxRateByZip5AndStateHandler($cartService, $taxRateService);
        $handler->handle($command);
    }
}
