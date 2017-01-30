<?php
namespace inklabs\kommerce\Lib\Event;

abstract class EventDispatcherDecorator implements EventDispatcherInterface
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

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

    /**
     * @param EventInterface[] $events
     */
    public function dispatchEvents(array $events)
    {
        $this->eventDispatcher->dispatchEvents($events);
    }

    public function dispatchEvent(EventInterface $event)
    {
        $this->eventDispatcher->dispatchEvent($event);
    }
}
