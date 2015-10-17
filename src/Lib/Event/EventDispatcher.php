<?php
namespace inklabs\kommerce\Lib\Event;

class EventDispatcher implements EventDispatcherInterface
{
    /** @var string[][] */
    private $listeners;

    public function addListener($eventClassName, $handlerClassName)
    {
        if (! isset($this->listeners[$eventClassName])) {
            $this->listeners[$eventClassName] = [];
        }

        $this->listeners[$eventClassName][] = $handlerClassName;
    }

    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            $this->dispatchEvent($event);
        }
    }

    private function dispatchEvent(EventInterface $event)
    {
        $eventClassName = get_class($event);
        if (! isset($this->listeners[$eventClassName])) {
            return;
        }

        foreach ($this->listeners[$eventClassName] as $handlerClassName) {
            $handler = $this->getHandler($handlerClassName);
            $handler->handle($event);
        }
    }

    /**
     * @param string $handlerClassName
     * @return EventHandlerInterface
     */
    private function getHandler($handlerClassName)
    {
        return new $handlerClassName;
    }
}
