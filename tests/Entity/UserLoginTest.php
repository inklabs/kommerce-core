<?php
namespace inklabs\kommerce\Entity;

class UserLoginTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $userLogin = new UserLogin;
        $userLogin->setId(1);
        $userLogin->setUsername('test');
        $userLogin->setIp4('8.8.8.8');
        $userLogin->setResult(UserLogin::RESULT_SUCCESS);

        $this->assertEquals(1, $userLogin->getId());
        $this->assertEquals('test', $userLogin->getUsername());
        $this->assertEquals('8.8.8.8', $userLogin->getIp4());
        $this->assertEquals(UserLogin::RESULT_SUCCESS, $userLogin->getResult());
    }
}
