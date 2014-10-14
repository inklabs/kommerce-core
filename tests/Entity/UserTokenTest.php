<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\UserToken;

class UserTokenTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->userToken = new UserToken;
        $this->userToken->setUserAgent('XXX');
        $this->userToken->setToken('XXX');
        $this->userToken->setType('XXX');
        $this->userToken->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
        $this->userToken->setExpires(null);
    }

    public function testGetToken()
    {
        $this->assertEquals('XXX', $this->userToken->getToken());
    }
}
