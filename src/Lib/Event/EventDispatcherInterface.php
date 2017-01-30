<?php
namespace inklabs\kommerce\Lib\Event;

interface EventDispatcherInterface
{
    /**
     * @param string $eventClassName
     * @param callable $callback
     */
    public function addListener($eventClassName, callable $callback);
    public function addSubscriber(EventSubscriberInterface $subscriber);

    /**
     * @param EventInterface[] $events
     */
    public function dispatchEvents(array $events);
    public function dispatchEvent(EventInterface $event);
}
