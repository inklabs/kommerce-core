<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Entity\Role;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $user = new User;
        $user->id = 1;
        $user->email = 'test@example.com';
        $user->username = 'test';
        $user->password = 'xxxx';
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->logins = 0;
        $user->last_login = null;
        $user->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $user->updated = null;

        $this->assertEquals(1, $user->id);
    }

    public function testAddRole()
    {
        $user = new User;
        $user->id = 1;
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $role = new Role;
        $role->id = 1;
        $role->name = 'admin';
        $role->description = 'Administrative user, has access to everything';
        $role->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $user->addRole($role);

        $this->assertEquals(1, count($user->roles));
    }

    public function testAddToken()
    {
        $user = new User;
        $user->id = 1;
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $user_token = new UserToken;
        $user_token->id = 1;
        $user_token->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $user->addToken($user_token);

        $this->assertEquals(1, count($user->tokens));
    }
}
