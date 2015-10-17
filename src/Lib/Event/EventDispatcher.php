<?php
namespace inklabs\kommerce\Lib\Event;

class EventDispatcher implements EventDispatcherInterface
{
    /** @var string[][] */
    private $listeners;

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $methodName) {
            $this->addListener($eventName, array($subscriber, $methodName));
        }
    }

    public function addListener($eventClassName, callable $callback)
    {
        if (! isset($this->listeners[$eventClassName])) {
            $this->listeners[$eventClassName] = [];
        }

        $this->listeners[$eventClassName][] = $callback;
    }

    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            $this->dispatchEvent($event);
        }
    }

    public function dispatchEvent(EventInterface $event)
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
