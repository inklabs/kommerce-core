<?php
namespace inklabs\kommerce\tests\Lib\Event;

use inklabs\kommerce\tests\Helper\Event\FakeEvent;

class FakeEventHandler
{
    public static $hasBeenCalled = false;

    public function __construct()
    {
        self::reset();
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

    public function handle(FakeEvent $event)
    {
        self::$hasBeenCalled = true;
    }
}
