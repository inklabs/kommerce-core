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

    public function addListener(string $eventClassName, callable $callback): void
    {
        $this->eventDispatcher->addListener($eventClassName, $callback);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber): void
    {
        $this->eventDispatcher->addSubscriber($subscriber);
    }

    public function dispatchEvents(array $events): void
    {
        $this->eventDispatcher->dispatchEvents($events);
    }

    public function dispatchEvent(EventInterface $event): void
    {
        $this->eventDispatcher->dispatchEvent($event);
    }
}
