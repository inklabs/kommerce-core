<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class UserLoginTest extends DoctrineTestCase
{
    public function testCreateDefaults()
    {
        $userLogin = new UserLogin;

        $this->assertSame(null, $userLogin->getEmail());
        $this->assertSame('0.0.0.0', $userLogin->getIp4());
        $this->assertSame(UserLogin::RESULT_FAIL, $userLogin->getResult());
        $this->assertSame('Fail', $userLogin->getResultText());
        $this->assertSame(null, $userLogin->getUser());
        $this->assertSame(null, $userLogin->getUserToken());
    }

    public function testCreate()
    {
        $user = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken();

        $userLogin = new UserLogin;
        $userLogin->setEmail('test@example.com');
        $userLogin->setIp4('127.0.0.1');
        $userLogin->setResult(UserLogin::RESULT_SUCCESS);
        $userLogin->setUser($user);
        $userLogin->setUserToken($userToken);

        $this->assertEntityValid($userLogin);
        $this->assertSame('test@example.com', $userLogin->getEmail());
        $this->assertSame('127.0.0.1', $userLogin->getIp4());
        $this->assertSame(UserLogin::RESULT_SUCCESS, $userLogin->getResult());
        $this->assertSame('Success', $userLogin->getResultText());
        $this->assertSame($user, $userLogin->getUser());
        $this->assertSame($userToken, $userLogin->getUserToken());
    }
}
