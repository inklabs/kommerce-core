<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\Event\EventInterface;

class FakeEventDispatcher extends EventDispatcher
{
    protected $dispatchedEvents = [];

    public function dispatchEvent(EventInterface $event)
    {
        parent::dispatchEvent($event);

        $eventClassName = get_class($event);
        $this->dispatchedEvents[$eventClassName] = true;
    }

    public function wasEventDispatched($eventClassName)
    {
        return isset($this->dispatchedEvents[$eventClassName]);
    }
}
