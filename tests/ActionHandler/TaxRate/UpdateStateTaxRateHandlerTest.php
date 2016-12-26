<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateStateTaxRateCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateStateTaxRateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTaxRateService();
        $tagService->shouldReceive('update')
            ->once();

        $applyToShipping = true;
        $command = new UpdateStateTaxRateCommand(
            self::UUID_HEX,
            self::STATE,
            self::FLOAT_TAX_RATE,
            $applyToShipping
        );
        $handler = new UpdateStateTaxRateHandler($tagService);
        $handler->handle($command);
    }
}
