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
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->user->getId());
        $this->assertEquals('test@example.com', $this->user->getEmail());
        $this->assertEquals('test', $this->user->getUsername());
        $this->assertEquals('xxxx', $this->user->getPassword());
        $this->assertEquals('John', $this->user->getFirstName());
        $this->assertEquals('Doe', $this->user->getLastName());
        $this->assertEquals(0, $this->user->getLogins());
        $this->assertEquals(null, $this->user->getLastLogin());
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
