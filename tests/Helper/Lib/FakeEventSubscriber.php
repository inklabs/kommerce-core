<?php
namespace inklabs\kommerce\tests\Helper\Lib;

use DateTime;
use inklabs\kommerce\Lib\Event\EventSubscriberInterface;
use inklabs\kommerce\tests\Helper\Event\FakeEvent;

class FakeEventSubscriber implements EventSubscriberInterface
{
    public static $hasBeenCalled = false;

    public function __construct(DateTime $fakeDependency)
    {
        self::reset();
    }

    public function getSubscribedEvents()
    {
        return [
            FakeEvent::class => 'onFakeEvent'
        ];
    }
    public function onFakeEvent(FakeEvent $event)
    {
        self::$hasBeenCalled = true;
    }

    public static function hasBeenCalled()
    {
        $hasBeenCalled = self::$hasBeenCalled;
        self::reset();
        return $hasBeenCalled;
    }

    protected static function reset()
    {
        self::$hasBeenCalled = false;
    }
}
