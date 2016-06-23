<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportOrdersFromCSVCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ImportOrdersFromCSVHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $importOrderService = $this->mockService->getImportOrderService();
        $importOrderService->shouldReceive('import')
            ->once();

        $command = new ImportOrdersFromCSVCommand(self::ORDERS_CSV_FILENAME);
        $handler = new ImportOrdersFromCSVHandler($importOrderService);
        $handler->handle($command);
    }
}
