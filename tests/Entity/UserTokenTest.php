<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use DateTimeZone;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;
use inklabs\kommerce\Lib\UuidInterface;

class UserTokenTest extends EntityTestCase
{
    /** @var UserToken */
    private $userToken;

    /** @var User */
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = $this->dummyData->getUser();
        $this->userToken = new UserToken($this->user);
    }

    public function testCreateDefaults()
    {
        $this->assertTrue($this->userToken->getId() instanceof UuidInterface);
        $this->assertTrue($this->userToken->getCreated() instanceof DateTime);
        $this->assertSame(null, $this->userToken->getUserAgent());
        $this->assertSame(false, $this->userToken->verifyToken('token'));
        $this->assertSame($this->user, $this->userToken->getUser());
        $this->assertSame(null, $this->userToken->getExpires());
        $this->assertTrue($this->userToken->getType()->isInternal());
    }

    public function testCreate()
    {
        $expires = new DateTime;
        $userTokenType = $this->dummyData->getUserTokenType();

        $this->userToken->setUserAgent('UserAgent');
        $this->userToken->setToken('token');
        $this->userToken->setType($userTokenType);
        $this->userToken->setExpires($expires);

        $this->assertEntityValid($this->userToken);
        $this->assertSame('UserAgent', $this->userToken->getUserAgent());
        $this->assertTrue($this->userToken->verifyToken('token'));
        $this->assertSame($userTokenType, $this->userToken->getType());
        $this->assertEquals($expires, $this->userToken->getExpires());
    }

    public function testCreateWithNullExpires()
    {
        $this->userToken->setExpires(null);
        $this->assertSame(null, $this->userToken->getExpires());
    }

    public function testGetRandomToken()
    {
        $this->assertSame(40, strlen(UserToken::getRandomToken()));
    }

    public function testVerifyTokenDateValid()
    {
        $this->userToken->setExpires(new DateTime('2015-10-21', new DateTimeZone('UTC')));

        $this->assertFalse($this->userToken->verifyTokenDateValid());
        $this->assertFalse($this->userToken->verifyTokenDateValid(new DateTime('2016-10-22', new DateTimeZone('UTC'))));
        $this->assertTrue($this->userToken->verifyTokenDateValid(new DateTime('2014-10-22', new DateTimeZone('UTC'))));
    }
}
