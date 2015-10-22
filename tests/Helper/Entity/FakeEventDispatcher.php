<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\Event\EventInterface;

class FakeEventDispatcher extends EventDispatcher
{
    protected $dispatchedEvents = [];

    public function dispatchEvent(EventInterface $event)
    {
        $eventClassName = get_class($event);
        $this->dispatchedEvents[$eventClassName][] = $event;

        parent::dispatchEvent($event);
    }

    public function getDispatchedEvents($eventClassName)
    {
        return $this->dispatchedEvents[$eventClassName];
    }
}
