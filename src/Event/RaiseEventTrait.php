<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;

trait RaiseEventTrait
{
    /** @var EventInterface[] */
    protected $pendingEvents = [];

    protected function raiseEvent(EventInterface $event): void
    {
        $this->pendingEvents[] = $event;
    }

    /**
     * @param EventInterface[] $events
     */
    protected function raiseEvents(array $events): void
    {
        $this->pendingEvents = array_merge($this->pendingEvents, $events);
    }

    /**
     * @return EventInterface[]
     */
    public function releaseEvents(): array
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];
        return $events;
    }
}
