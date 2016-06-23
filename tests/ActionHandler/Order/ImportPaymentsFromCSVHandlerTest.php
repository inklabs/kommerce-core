<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportPaymentsFromCSVCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ImportPaymentsFromCSVHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $importPaymentService = $this->mockService->getImportPaymentService();
        $importPaymentService->shouldReceive('import')
            ->once();

        $command = new ImportPaymentsFromCSVCommand(self::ORDERS_CSV_FILENAME);
        $handler = new ImportPaymentsFromCSVHandler($importPaymentService);
        $handler->handle($command);
    }
}
