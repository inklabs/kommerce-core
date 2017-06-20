<?php
namespace inklabs\kommerce\Lib\Event;

class EventDispatcher implements EventDispatcherInterface
{
    /** @var string[][] */
    private $listeners;

    protected $dispatchedEvents = [];

    public function addSubscriber(EventSubscriberInterface $subscriber): void
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $methodName) {
            $this->addListener($eventName, [$subscriber, $methodName]);
        }
    }

    public function addListener(string $eventClassName, callable $callback): void
    {
        if (! isset($this->listeners[$eventClassName])) {
            $this->listeners[$eventClassName] = [];
        }

        $this->listeners[$eventClassName][] = $callback;
    }

    public function dispatchEvents(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatchEvent($event);
        }
    }

    public function dispatchEvent(EventInterface $event): void
    {
        $eventName = get_class($event);
        if (! isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $listener) {
            call_user_func($listener, $event, $eventName);
        }
    }
}
