<?php
namespace inklabs\kommerce\Entity;

class UserTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $userToken = new UserToken;
        $userToken->setUserAgent('UserAgent');
        $userToken->setToken('token');
        $userToken->setType(UserToken::TYPE_GOOGLE);
        $userToken->setExpires(new \DateTime);
        $userToken->setUser(new User);

        $this->assertEquals(null, $userToken->getId());
        $this->assertEquals('UserAgent', $userToken->getUserAgent());
        $this->assertEquals('token', $userToken->getToken());
        $this->assertEquals(UserToken::TYPE_GOOGLE, $userToken->getType());
        $this->assertTrue($userToken->getExpires() instanceof \DateTime);
        $this->assertTrue($userToken->getUser() instanceof User);
        $this->assertTrue($userToken->getView() instanceof View\UserToken);
    }

    public function testCreateWithNullExpires()
    {
        $userToken = new UserToken;
        $userToken->setExpires(null);
        $this->assertEquals(null, $userToken->getExpires());
    }
}
