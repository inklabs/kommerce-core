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

        $command = new ImportUsersFromCSVCommand(self::USERS_CSV_FILENAME);
        $handler = new ImportUsersFromCSVHandler($userImportService);
        $handler->handle($command);
    }
}
