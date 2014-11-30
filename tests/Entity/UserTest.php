<?php
namespace inklabs\kommerce\Entity;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /* @var User */
    protected $user;

    public function setUp()
    {
        $this->user = new User;
        $this->user->setEmail('test@example.com');
        $this->user->setUsername('test');
        $this->user->setPassword('xxxx');
        $this->user->setFirstName('John');
        $this->user->setLastName('Doe');
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->user->getId());
        $this->assertEquals('test@example.com', $this->user->getEmail());
        $this->assertEquals('test', $this->user->getUsername());
        $this->assertEquals('John', $this->user->getFirstName());
        $this->assertEquals('Doe', $this->user->getLastName());
        $this->assertEquals(0, $this->user->getTotalLogins());
        $this->assertEquals(null, $this->user->getLastLogin());
    }

    public function testAddRole()
    {
        $role = new Role;
        $role->setName('admin');
        $role->setDescription('Administrative user, has access to everything');

        $this->user->addRole($role);

        $this->assertEquals(1, count($this->user->getRoles()));
    }

    public function testAddToken()
    {
        $this->user->addToken(new UserToken);
        $this->assertEquals(1, count($this->user->getTokens()));
    }
}
