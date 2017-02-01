<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ImportUsersFromCSVCommand;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Event\ImportedUsersFromCSVEvent;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ImportUsersFromCSVHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
    ];

    public function testHandle()
    {
        $command = new ImportUsersFromCSVCommand(self::USERS_CSV_FILENAME);
        $this->setCountLogger();

        $this->dispatchCommand($command);

        /** @var ImportedUsersFromCSVEvent $event */
        $event = $this->getDispatchedEvents()[0];
        $this->assertTrue($event instanceof ImportedUsersFromCSVEvent);
        $this->assertSame(3, $event->getSuccessCount());
        $this->assertSame(1, $event->getFailedCount());
        $this->assertSame(9, $this->getTotalQueries());
    }
}
