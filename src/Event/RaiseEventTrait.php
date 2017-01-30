<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;

trait RaiseEventTrait
{
    /** @var EventInterface[] */
    protected $pendingEvents = [];

    protected function raiseEvent(EventInterface $event)
    {
        $this->pendingEvents[] = $event;
    }

    /**
     * @param EventInterface[] $events
     */
    protected function raiseEvents($events)
    {
        $this->pendingEvents = array_merge($this->pendingEvents, $events);
    }

    /**
     * @return EventInterface[]
     */
    public function releaseEvents()
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];
        return $events;
    }
}
