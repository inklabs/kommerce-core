<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\Event\EventInterface;

trait EventGeneratorTrait
{
    protected $pendingEvents = [];

    protected function raise(EventInterface $event)
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

    public function releaseEvents()
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];
        return $events;
    }
}
