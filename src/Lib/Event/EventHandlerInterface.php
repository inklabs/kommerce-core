<?php
namespace inklabs\kommerce\Lib\Event;

interface EventHandlerInterface
{
    public function handle(EventInterface $event);
}
