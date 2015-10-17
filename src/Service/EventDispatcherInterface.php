<?php
namespace inklabs\kommerce\Service;

interface EventDispatcherInterface
{
    public function dispatch(array $events);
}
