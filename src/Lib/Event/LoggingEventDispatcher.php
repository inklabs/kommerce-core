<?php
namespace inklabs\kommerce\Lib\Event;

class LoggingEventDispatcher implements EventDispatcherInterface
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var EventInterface[] */
    protected $dispatchedEvents = [];

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $eventClassName
     * @param callable $callback
     */
    public function addListener($eventClassName, callable $callback)
    {
        $this->eventDispatcher->addListener($eventClassName, $callback);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->eventDispatcher->addSubscriber($subscriber);
    }

    public function dispatchEvent(EventInterface $event)
    {
        $this->logDispatchedEvent($event);
        $this->eventDispatcher->dispatchEvent($event);
    }

    /**
     * @param EventInterface[] $events
     */
    public function dispatchEvents(array $events)
    {
        foreach ($events as $event) {
            $this->logDispatchedEvent($event);
        }
        $this->eventDispatcher->dispatchEvents($events);
    }

    public function getDispatchedEvents()
    {
        return $this->dispatchedEvents;
    }

    private function logDispatchedEvent(EventInterface $event)
    {
        $this->dispatchedEvents[] = $event;
    }
}
