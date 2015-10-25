<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use DateTimeZone;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class UserTokenTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $userToken = new UserToken;
        $userToken->setUserAgent('UserAgent');
        $userToken->setToken('token');
        $userToken->setType(UserToken::TYPE_GOOGLE);
        $userToken->setExpires(new DateTime);
        $userToken->setUser(new User);

        $this->assertEntityValid($userToken);
        $this->assertSame(null, $userToken->getId());
        $this->assertSame('UserAgent', $userToken->getUserAgent());
        $this->assertSame(true, $userToken->verifyToken('token'));
        $this->assertSame(UserToken::TYPE_GOOGLE, $userToken->getType());
        $this->assertSame('Google', $userToken->getTypeText());
        $this->assertTrue($userToken->getExpires() instanceof DateTime);
        $this->assertTrue($userToken->getUser() instanceof User);
    }

    public function testCreateWithNullExpires()
    {
        $userToken = new UserToken;
        $userToken->setExpires(null);
        $this->assertSame(null, $userToken->getExpires());
    }

    public function testGetRandomToken()
    {
        $this->assertSame(40, strlen(UserToken::getRandomToken()));
    }

    public function testVerifyTokenDateValid()
    {
        $userToken = new UserToken;
        $userToken->setExpires(new DateTime('2015-10-21', new DateTimeZone('UTC')));

        $this->assertFalse($userToken->verifyTokenDateValid());
        $this->assertFalse($userToken->verifyTokenDateValid(new DateTime('2016-10-22', new DateTimeZone('UTC'))));
        $this->assertTrue($userToken->verifyTokenDateValid(new DateTime('2014-10-22', new DateTimeZone('UTC'))));
    }
}
