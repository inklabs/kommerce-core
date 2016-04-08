<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use DateTimeZone;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UserTokenTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $userToken = new UserToken;

        $this->assertSame(null, $userToken->getId());
        $this->assertSame(null, $userToken->getUserAgent());
        $this->assertSame(false, $userToken->verifyToken('token'));
        $this->assertSame(null, $userToken->getUser());
        $this->assertSame(null, $userToken->getExpires());
        $this->assertTrue($userToken->getType()->isInternal());
    }

    public function testCreate()
    {
        $expires = new DateTime;
        $user = $this->dummyData->getuser();

        $userToken = new UserToken;
        $userToken->setUserAgent('UserAgent');
        $userToken->setToken('token');
        $userToken->setType(UserTokenType::google());
        $userToken->setExpires($expires);
        $userToken->setUser($user);

        $this->assertEntityValid($userToken);
        $this->assertSame(null, $userToken->getId());
        $this->assertSame('UserAgent', $userToken->getUserAgent());
        $this->assertSame(true, $userToken->verifyToken('token'));
        $this->assertSame($user, $userToken->getUser());
        $this->assertEquals($expires, $userToken->getExpires());
        $this->assertTrue($userToken->getType()->isGoogle());
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
