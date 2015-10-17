<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use inklabs\kommerce\Service\EventDispatcherInterface;

class FakeEventDispatcher implements EventDispatcherInterface
{
    protected $dispatchCalled = false;

    public function dispatch(array $events)
    {
        $this->dispatchCalled = true;
    }

    public function wasDispatchCalled()
    {
        return $this->dispatchCalled;
    }
}
