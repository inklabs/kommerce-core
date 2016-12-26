<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateZip5TaxRateCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateZip5TaxRateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTaxRateService();
        $tagService->shouldReceive('update')
            ->once();

        $applyToShipping = true;
        $command = new UpdateZip5TaxRateCommand(
            self::UUID_HEX,
            self::ZIP5,
            self::FLOAT_TAX_RATE,
            $applyToShipping
        );
        $handler = new UpdateZip5TaxRateHandler($tagService);
        $handler->handle($command);
    }
}
