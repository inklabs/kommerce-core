<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateZip5TaxRateCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateZip5TaxRateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTaxRateService();
        $tagService->shouldReceive('create')
            ->once();

        $applyToShipping = true;
        $command = new CreateZip5TaxRateCommand(
            self::ZIP5,
            self::FLOAT_TAX_RATE,
            $applyToShipping
        );
        $handler = new CreateZip5TaxRateHandler($tagService);
        $handler->handle($command);
    }
}
