<?php
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Entity\Role;

class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers User::__construct
     */
    public function test_construct()
    {
        $user = new User;
        $user->id = 1;
        $user->email = 'test@example.com';
        $user->username = 'test';
        $user->password = 'xxxx';
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->logins = 0;
        $user->last_login = NULL;
        $user->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $user->updated = NULL;

        $this->assertEquals(1, $user->id);
    }

    /**
     * @covers User::add_role
     */
    public function test_add_role()
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

        $user->add_role($role);

        $this->assertEquals(1, count($user->roles));
    }

    /**
     * @covers User::add_token
     */
    public function test_add_token()
    {
        $user = new User;
        $user->id = 1;
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $user_token = new UserToken;
        $user_token->id = 1;
        $user_token->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $user->add_token($user_token);

        $this->assertEquals(1, count($user->tokens));
    }
}
