<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use inklabs\kommerce\Lib\Event\EventDispatcher;

class FakeEventDispatcher extends EventDispatcher
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
