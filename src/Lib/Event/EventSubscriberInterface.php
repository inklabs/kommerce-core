<?php
namespace inklabs\kommerce\Lib\Event;

interface EventSubscriberInterface
{
    /**
     *  ['eventName' => 'methodName']
     *
     * @return string[]
     */
    public function getSubscribedEvents();
}
