<?php
namespace inklabs\kommerce\Entity;

trait EventGeneratorTrait
{
    protected $pendingEvents = [];

    protected function raise($event)
    {
        $this->pendingEvents[] = $event;
    }

    public function releaseEvents()
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];
        return $events;
    }
}
