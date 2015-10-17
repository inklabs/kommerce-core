<?php
namespace inklabs\kommerce\Lib;

use DateTime;
use inklabs\kommerce\Lib\Event\EventInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Event\FakeEvent;
use inklabs\kommerce\tests\Helper\Event\FakeEvent2;
use inklabs\kommerce\tests\Lib\Event\FakeEventSubscriber;

class EventDispatcherTest extends DoctrineTestCase
{
    public function testAddSubscriberAndDispatchFiresSubscriber()
    {
        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->addSubscriber(new FakeEventSubscriber(new DateTime));
        $eventDispatcher->dispatch(
            [new FakeEvent]
        );

        $this->assertTrue(FakeEventSubscriber::hasBeenCalled());
    }

    public function testAddSubscriberAndDispatchDoesNotFiresSubscriber()
    {
        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->addSubscriber(new FakeEventSubscriber(new DateTime));
        $eventDispatcher->dispatch(
            [new FakeEvent2]
        );

        $this->assertFalse(FakeEventSubscriber::hasBeenCalled());
    }

    public function testAddListenerAndDispatchFiresListener()
    {
        $hasBeenCalled = false;
        $callable = function (EventInterface $event) use (& $hasBeenCalled) {
            $hasBeenCalled = true;
        };

        $this->assertFalse($hasBeenCalled);

        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->addListener(FakeEvent::class, $callable);
        $eventDispatcher->dispatch(
            [new FakeEvent]
        );

        $this->assertTrue($hasBeenCalled);
    }
}
