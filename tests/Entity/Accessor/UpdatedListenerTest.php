<?php
namespace inklabs\kommerce\Entity\Accessor;

class UpdatedListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testPreUpdate()
    {
        $listener = new UpdatedListener;
        $listener->preUpdate(null);
        $this->assertTrue($listener->updated > 0);
    }
}
