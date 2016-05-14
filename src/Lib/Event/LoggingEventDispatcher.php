<?php
namespace inklabs\kommerce\Lib\Event;

class LoggingEventDispatcher extends EventDispatcherDecorator
{
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

    public function getEventStrings()
    {
        return $this->events;
    }

    /**
     * @param EventInterface $event
     */
    protected function logEvent(EventInterface $event)
    {
        $this->events[] = get_class($event);
    }
}
