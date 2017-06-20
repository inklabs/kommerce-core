<?php
namespace inklabs\kommerce\Lib\Event;

interface EventDispatcherInterface
{
    public function addListener(string $eventClassName, callable $callback): void;
    public function addSubscriber(EventSubscriberInterface $subscriber): void;

    /**
     * @param EventInterface[] $events
     */
    public function dispatchEvents(array $events): void;
    public function dispatchEvent(EventInterface $event): void;
}
