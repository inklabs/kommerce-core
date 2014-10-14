<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\UserLogin;

class UserLoginTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->userLogin = new UserLogin;
        $this->userLogin->setUsername('test');
        $this->userLogin->setUserId(1);
        $this->userLogin->setIp4('8.8.8.8');
        $this->userLogin->setResult('success');
        $this->userLogin->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetUsername()
    {
        $this->assertEquals('test', $this->userLogin->getUsername());
    }
}
