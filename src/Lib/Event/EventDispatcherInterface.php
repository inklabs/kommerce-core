<?php
namespace inklabs\kommerce\Lib\Event;

interface EventDispatcherInterface
{
    /**
     * @param EventInterface[] $events
     */
    public function dispatch(array $events);

    /**
     * @param string $eventClassName
     * @param callable $callback
     */
    public function addListener($eventClassName, callable $callback);
    public function addSubscriber(EventSubscriberInterface $subscriber);
}
