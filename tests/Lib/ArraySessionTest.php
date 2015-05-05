<?php
namespace inklabs\kommerce\Lib;

class ArraySessionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAndSet()
    {
        $sessionManager = new ArraySession;
        $sessionManager->set('test', 'test-data');
        $this->assertSame('test-data', $sessionManager->get('test'));
    }

    public function testGetMiss()
    {
        $sessionManager = new ArraySession;
        $this->assertSame(null, $sessionManager->get('test'));
    }

    public function testDelete()
    {
        $sessionManager = new ArraySession;
        $sessionManager->set('test', 'test-data');
        $this->assertSame('test-data', $sessionManager->get('test'));

        $sessionManager->delete('test');
        $this->assertSame(null, $sessionManager->get('test'));
    }
}
