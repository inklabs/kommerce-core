<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;

class UserTest extends Helper\DoctrineTestCase
{
    /* @var User */
    protected $userService;
    protected $sessionManager;

    public function setUp()
    {
        $this->sessionManager = new Lib\ArraySessionManager;
        $this->userService = new User($this->entityManager, $this->sessionManager);

        $user = new Entity\User;
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('test@example.com');
        $user->setUsername('test');
        $user->setPassword('qwerty');

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function testUserDoesNotExist()
    {
        $user = $this->userService->find(0);
        $this->assertEquals(null, $user);
    }

    public function testUserExists()
    {
        $user = $this->userService->find(1);
        $this->assertEquals(1, $user->id);
        $this->assertEquals('John', $user->firstName);
        $this->assertEquals('Doe', $user->lastName);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('test', $user->username);
        $this->assertEquals(Entity\User::STATUS_ACTIVE, $user->status);
    }

    public function testUserLoginWithUsername()
    {
        $result = $this->userService->login('test', 'qwerty');
        $this->assertEquals(true, $result);
    }

    public function testUserLoginWithWrongPassword()
    {
        $result = $this->userService->login('test', 'xxxxx');
        $this->assertEquals(false, $result);
    }

    public function testUserLoginWithWrongUsername()
    {
        $result = $this->userService->login('xxxxx', 'xxxxx');
        $this->assertEquals(false, $result);
    }

    public function testUserPersistence()
    {
        $user = $this->userService->getView();
        $this->assertEquals(null, $user->id);
        $this->assertEquals(0, $user->totalLogins);

        $result = $this->userService->login('test', 'qwerty');
        $this->assertEquals(true, $result);

        $userService = new User($this->entityManager, $this->sessionManager);
        $user = $userService->getView();
        $this->assertEquals(1, $user->id);
        $this->assertEquals(1, $user->totalLogins);
    }
}
