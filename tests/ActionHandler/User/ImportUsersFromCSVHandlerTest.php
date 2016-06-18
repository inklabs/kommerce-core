<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ImportUsersFromCSVCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ImportUsersFromCSVHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $userImportService = $this->mockService->getImportUserService();
        $userImportService->shouldReceive('import')
            ->once();

        // TODO: Move this user import csv file to a sane location
        $fileName = __DIR__ . '/../../Lib/PaymentGateway/CSVIteratorTest.csv';

        $command = new ImportUsersFromCSVCommand($fileName);
        $handler = new ImportUsersFromCSVHandler($userImportService);
        $handler->handle($command);
    }
}
