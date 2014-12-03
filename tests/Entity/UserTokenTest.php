<?php
namespace inklabs\kommerce\Entity;

class UserTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $userToken = new UserToken;
        $userToken->setUserAgent('UserAgent');
        $userToken->setToken('token');
        $userToken->setType('type');
        $userToken->setExpires(null);

        $this->assertEquals(null, $userToken->getId());
        $this->assertEquals('UserAgent', $userToken->getUserAgent());
        $this->assertEquals('token', $userToken->getToken());
        $this->assertEquals('type', $userToken->getType());
        $this->assertEquals(null, $userToken->getExpires());
    }
}
