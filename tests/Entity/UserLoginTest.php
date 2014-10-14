<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\UserLogin;

class UserLoginTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $user_login = new UserLogin;
        $user_login->id = 1;
        $user_login->username = 'test';
        $user_login->user_id = 1;
        $user_login->ip4 = '8.8.8.8';
        $user_login->result = 'success';
        $user_login->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->assertEquals(1, $user_login->id);
    }
}
