<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Entity\Role;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->user = new User;
        $this->user->setEmail('test@example.com');
        $this->user->setUsername('test');
        $this->user->setPassword('xxxx');
        $this->user->setFirstName('John');
        $this->user->setLastName('Doe');
        $this->user->setLogins(0);
        $this->user->setLastLogin(null);
        $this->user->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetUsername()
    {
        $this->assertEquals('test', $this->user->getUsername());
    }

    public function testAddRole()
    {
        $role = new Role;
        $role->setName('admin');
        $role->setDescription('Administrative user, has access to everything');
        $role->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->user->addRole($role);

        $this->assertEquals(1, count($this->user->getRoles()));
    }

    public function testAddToken()
    {
        $userToken = new UserToken;
        $userToken->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->user->addToken($userToken);

        $this->assertEquals(1, count($this->user->getTokens()));
    }
}
