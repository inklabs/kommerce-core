<?php
namespace inklabs\kommerce;

class UserTokenTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->userToken = new Entity\UserToken;
        $this->userToken->setUserAgent('XXX');
        $this->userToken->setToken('XXX');
        $this->userToken->setType('XXX');
        $this->userToken->setExpires(null);
    }

    public function testGetter()
    {
        $this->assertEquals(null, $this->userToken->getId());
        $this->assertEquals('XXX', $this->userToken->getUserAgent());
        $this->assertEquals('XXX', $this->userToken->getToken());
        $this->assertEquals('XXX', $this->userToken->getType());
        $this->assertEquals(null, $this->userToken->getExpires());
    }
}
