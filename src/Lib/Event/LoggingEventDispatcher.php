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

    public function addListener(string $eventClassName, callable $callback): void
    {
        $this->eventDispatcher->addListener($eventClassName, $callback);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber): void
    {
        $this->eventDispatcher->addSubscriber($subscriber);
    }

    public function dispatchEvent(EventInterface $event): void
    {
        $this->logDispatchedEvent($event);
        $this->eventDispatcher->dispatchEvent($event);
    }

    /**
     * @param EventInterface[] $events
     */
    public function dispatchEvents(array $events): void
    {
        foreach ($events as $event) {
            $this->logDispatchedEvent($event);
        }
        $this->eventDispatcher->dispatchEvents($events);
    }

    /**
     * @return EventInterface[] $events
     */

    public function getDispatchedEvents(): array
    {
        return $this->dispatchedEvents;
    }

    private function logDispatchedEvent(EventInterface $event): void
    {
        $this->dispatchedEvents[] = $event;
    }
}
