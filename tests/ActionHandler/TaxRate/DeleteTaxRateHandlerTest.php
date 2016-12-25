<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\DeleteTaxRateCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteTaxRateHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTaxRateService();
        $tagService->shouldReceive('delete')
            ->once();

        $command = new DeleteTaxRateCommand(self::UUID_HEX);
        $handler = new DeleteTaxRateHandler($tagService);
        $handler->handle($command);
    }
}
