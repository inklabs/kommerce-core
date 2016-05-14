<?php
namespace inklabs\kommerce\Lib\Event;

class LoggingEventDispatcher extends EventDispatcherDecorator
{
    /** @var EventInterface[] */
    private $events = [];

    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            $this->logEvent($event);
        }

        parent::dispatch($events);
    }

    public function dispatchEvent(EventInterface $event)
    {
        $this->logEvent($event);
        parent::dispatchEvent($event);
    }

    /**
     * @return EventInterface[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param EventInterface $event
     */
    protected function logEvent(EventInterface $event)
    {
        $this->events[] = $event;
    }
}
