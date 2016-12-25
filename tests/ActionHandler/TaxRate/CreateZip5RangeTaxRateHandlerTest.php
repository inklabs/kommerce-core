<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateZip5RangeTaxRateCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateZip5RangeTaxRateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTaxRateService();
        $tagService->shouldReceive('create')
            ->once();

        $applyToShipping = true;
        $command = new CreateZip5RangeTaxRateCommand(
            self::ZIP5,
            self::ZIP5,
            self::FLOAT_TAX_RATE,
            $applyToShipping
        );
        $handler = new CreateZip5RangeTaxRateHandler($tagService);
        $handler->handle($command);
    }
}
