<?php
namespace inklabs\kommerce\Lib\Command;

use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Action\Fake\FakeUpdateCommand;

class CommandBusTest extends Helper\DoctrineTestCase
{
    public function testCreate()
    {
        $commandBus = new CommandBus($this->serviceFactoryWithFakeRepositoryFactory());
        $command = new FakeUpdateCommand('John Doe', 'john@example.com');
        $commandBus->execute($command);

        $this->assertSame(1, $command->getReturnId());
    }
}
