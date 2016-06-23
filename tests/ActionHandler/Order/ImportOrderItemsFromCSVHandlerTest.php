<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportOrderItemsFromCSVCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ImportOrderItemsFromCSVHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $importOrderItemService = $this->mockService->getImportOrderItemService();
        $importOrderItemService->shouldReceive('import')
            ->once();

        $command = new ImportOrderItemsFromCSVCommand(self::ORDERS_CSV_FILENAME);
        $handler = new ImportOrderItemsFromCSVHandler($importOrderItemService);
        $handler->handle($command);
    }
}
