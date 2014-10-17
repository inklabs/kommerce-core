<?php
namespace inklabs\kommerce\Entity;

class UserLoginTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->userLogin = new UserLogin;
        $this->userLogin->setUsername('test');
        $this->userLogin->setUserId(1);
        $this->userLogin->setIp4('8.8.8.8');
        $this->userLogin->setResult('success');
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->userLogin->getId());
        $this->assertEquals('test', $this->userLogin->getUsername());
        $this->assertEquals(1, $this->userLogin->getUserId());
        $this->assertEquals('8.8.8.8', $this->userLogin->getIp4());
        $this->assertEquals('success', $this->userLogin->getResult());
    }
}
