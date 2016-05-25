<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UserLoginTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $userLogin = new UserLogin;

        $this->assertSame(null, $userLogin->getEmail());
        $this->assertSame('0.0.0.0', $userLogin->getIp4());
        $this->assertSame(null, $userLogin->getUser());
        $this->assertSame(null, $userLogin->getUserToken());
        $this->assertTrue($userLogin->getResult()->isFail());
    }

    public function testCreate()
    {
        $user = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken();
        $userLoginResult = $this->dummyData->getUserLoginResultType();

        $userLogin = new UserLogin($user, $userToken);
        $userLogin->setEmail('test@example.com');
        $userLogin->setIp4('127.0.0.1');
        $userLogin->setResult($userLoginResult);

        $this->assertEntityValid($userLogin);
        $this->assertSame('test@example.com', $userLogin->getEmail());
        $this->assertSame('127.0.0.1', $userLogin->getIp4());
        $this->assertSame($userLoginResult, $userLogin->getResult());
        $this->assertSame($user, $userLogin->getUser());
        $this->assertSame($userToken, $userLogin->getUserToken());
    }
}
