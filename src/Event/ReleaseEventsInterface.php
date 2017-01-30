<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;

interface ReleaseEventsInterface
{
    /**
     * @return EventInterface[]
     */
    public function releaseEvents();
}
