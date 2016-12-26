<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateZip5RangeTaxRateCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateZip5RangeTaxRateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTaxRateService();
        $tagService->shouldReceive('update')
            ->once();

        $applyToShipping = true;
        $command = new UpdateZip5RangeTaxRateCommand(
            self::UUID_HEX,
            self::ZIP5,
            self::ZIP5,
            self::FLOAT_TAX_RATE,
            $applyToShipping
        );
        $handler = new UpdateZip5RangeTaxRateHandler($tagService);
        $handler->handle($command);
    }
}
