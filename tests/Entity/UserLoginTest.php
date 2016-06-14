<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UserLoginTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $email = 'john.doe@example.com';
        $ip4 = '127.0.0.1';
        $result = $this->dummyData->getUserLoginResultType();

        $userLogin = new UserLogin(
            $result,
            $email,
            $ip4
        );

        $this->assertEntityValid($userLogin);
        $this->assertSame($email, $userLogin->getEmail());
        $this->assertSame($ip4, $userLogin->getIp4());
        $this->assertSame(null, $userLogin->getUser());
        $this->assertSame(null, $userLogin->getUserToken());
        $this->assertSame($result, $userLogin->getResult());
    }

    public function testCreate()
    {
        $user = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken();
        $result = $this->dummyData->getUserLoginResultType();
        $email = 'john.doe@example.com';
        $ip4 = '127.0.0.1';

        $userLogin = new UserLogin(
            $result,
            $email,
            $ip4,
            $user,
            $userToken
        );

        $this->assertEntityValid($userLogin);
        $this->assertSame($email, $userLogin->getEmail());
        $this->assertSame($ip4, $userLogin->getIp4());
        $this->assertSame($result, $userLogin->getResult());
        $this->assertSame($user, $userLogin->getUser());
        $this->assertSame($userToken, $userLogin->getUserToken());
    }
}
