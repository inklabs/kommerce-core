<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Event\FakeEvent;
use inklabs\kommerce\tests\Lib\Event\FakeEventHandler;

class EventDispatcherTest extends DoctrineTestCase
{
    public function testDispatchFiresHandler()
    {
        $this->setupEntityManager([]);

        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->addListener(FakeEvent::class, FakeEventHandler::class);
        $eventDispatcher->dispatch(
            [new FakeEvent]
        );

        $this->assertTrue(FakeEventHandler::hasBeenCalled());
    }

    public function testDispatchFailsToFire()
    {
        $this->setupEntityManager([]);

        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->addListener('NonExistentClass', FakeEventHandler::class);
        $eventDispatcher->dispatch(
            [new FakeEvent]
        );

        $this->assertFalse(FakeEventHandler::hasBeenCalled());
    }
}
