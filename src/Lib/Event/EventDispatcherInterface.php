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
     * @param string $handlerClassName
     */
    public function addListener($eventClassName, $handlerClassName);
}
