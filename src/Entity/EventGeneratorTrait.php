<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\Event\EventInterface;

trait EventGeneratorTrait
{
    protected $pendingEvents = [];

    protected function raise(EventInterface $event): void
    {
        $this->pendingEvents[] = $event;
    }

    /**
     * @param EventInterface[] $events
     */
    protected function raiseEvents(array $events)
    {
        $this->pendingEvents = array_merge($this->pendingEvents, $events);
    }

    public function releaseEvents(): array
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];
        return $events;
    }
}
