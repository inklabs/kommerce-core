<?php
namespace inklabs\kommerce\Lib;

use DateTime;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\Event\LoggingEventDispatcher;
use inklabs\kommerce\tests\Helper\Event\FakeEvent;
use inklabs\kommerce\tests\Helper\Event\FakeEvent2;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;
use inklabs\kommerce\tests\Helper\Lib\FakeEventSubscriber;

class LoggingEventDispatcherTest extends ServiceTestCase
{
    public function testAddSubscriberAndDispatchFiresSubscriber()
    {
        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->addSubscriber(new FakeEventSubscriber(new DateTime()));
        $eventDispatcher->dispatch([
            new FakeEvent()
        ]);

        $this->assertTrue(FakeEventSubscriber::hasBeenCalled());
    }

    public function testLoggingDecorator()
    {
        $loggingEventDispatcher = new LoggingEventDispatcher(
            new EventDispatcher()
        );
        $loggingEventDispatcher->addListener(
            FakeEvent::class,
            function () {
            }
        );
        $loggingEventDispatcher->addSubscriber(new FakeEventSubscriber(new DateTime()));
        $loggingEventDispatcher->dispatchEvent(new FakeEvent());
        $loggingEventDispatcher->dispatch([
            new FakeEvent(),
            new FakeEvent2(),
            new FakeEvent(),
        ]);

        $expected = [
            FakeEvent::class,
            FakeEvent::class,
            FakeEvent2::class,
            FakeEvent::class
        ];

        $this->assertSame($expected, $loggingEventDispatcher->getEventStrings());
    }
}
