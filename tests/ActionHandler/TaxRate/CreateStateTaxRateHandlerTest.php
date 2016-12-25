<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateStateTaxRateCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateStateTaxRateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTaxRateService();
        $tagService->shouldReceive('create')
            ->once();

        $applyToShipping = true;
        $command = new CreateStateTaxRateCommand(
            self::STATE,
            self::FLOAT_TAX_RATE,
            $applyToShipping
        );
        $handler = new CreateStateTaxRateHandler($tagService);
        $handler->handle($command);
    }
}
