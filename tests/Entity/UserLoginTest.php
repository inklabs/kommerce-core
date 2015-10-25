<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class UserLoginTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $userLogin = new UserLogin;
        $userLogin->setEmail('test@example.com');
        $userLogin->setIp4('8.8.8.8');
        $userLogin->setResult(UserLogin::RESULT_SUCCESS);
        $userLogin->setUser(new User);

        $this->assertEntityValid($userLogin);
        $this->assertSame('test@example.com', $userLogin->getEmail());
        $this->assertSame('8.8.8.8', $userLogin->getIp4());
        $this->assertSame(UserLogin::RESULT_SUCCESS, $userLogin->getResult());
        $this->assertSame('Success', $userLogin->getResultText());
        $this->assertTrue($userLogin->getUser() instanceof User);
    }
}
