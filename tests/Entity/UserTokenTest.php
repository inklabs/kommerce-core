<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use DateTimeZone;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;
use inklabs\kommerce\Lib\UuidInterface;

class UserTokenTest extends EntityTestCase
{
    const TOKEN = 'token123';

    /** @var UserToken */
    private $userToken;

    /** @var User */
    private $user;

    /** @var DateTime */
    private $expires;

    public function setUp()
    {
        parent::setUp();
        $this->user = $this->dummyData->getUser();
        $this->expires = new DateTime('2015-10-21', new DateTimeZone('UTC'));

        $this->userToken = new UserToken(
            $this->user,
            $this->dummyData->getUserTokenType(),
            self::TOKEN,
            self::USER_AGENT,
            self::IP4,
            $this->expires
        );
    }

    public function testCreateDefaults()
    {
        $this->assertEntityValid($this->userToken);
        $this->assertTrue($this->userToken->getId() instanceof UuidInterface);
        $this->assertTrue($this->userToken->getCreated() instanceof DateTime);
        $this->assertSame(self::USER_AGENT, $this->userToken->getUserAgent());
        $this->assertFalse($this->userToken->verifyToken('wrong-token'));
        $this->assertTrue($this->userToken->verifyToken(self::TOKEN));
        $this->assertEntitiesEqual($this->user, $this->userToken->getUser());
        $this->assertEquals($this->expires, $this->userToken->getExpires());
        $this->assertTrue($this->userToken->getType()->isInternal());
    }

    public function testCreate()
    {
        $userLogin = $this->dummyData->getUserLogin();
        $this->userToken->addUserLogin($userLogin);
        $this->assertEntityValid($this->userToken);
    }

    public function testCreateWithNullExpires()
    {
        $userToken = new UserToken(
            $this->user,
            $this->dummyData->getUserTokenType(),
            self::TOKEN,
            self::USER_AGENT,
            self::IP4
        );

        $this->assertSame(null, $userToken->getExpires());
    }

    public function testGetRandomToken()
    {
        $this->assertSame(40, strlen(UserToken::getRandomToken()));
    }

    public function testVerifyTokenDateValid()
    {
        $this->assertFalse($this->userToken->verifyTokenDateValid());
        $this->assertFalse($this->userToken->verifyTokenDateValid(new DateTime('2016-10-22', new DateTimeZone('UTC'))));
        $this->assertTrue($this->userToken->verifyTokenDateValid(new DateTime('2014-10-22', new DateTimeZone('UTC'))));
    }
}
