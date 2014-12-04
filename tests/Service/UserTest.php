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
    }

    public function setupUser()
    {
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
        $this->setupUser();

        $user = $this->userService->find(1);
        $this->assertEquals(1, $user->id);
    }

    public function testUserLoginWithUsername()
    {
        $this->setupUser();
        $this->assertTrue($this->userService->login('test', 'qwerty'));
    }

    public function testUserLoginWithWrongPassword()
    {
        $this->setupUser();
        $this->assertFalse($this->userService->login('test', 'xxxxx'));
    }

    public function testUserLoginWithWrongUsername()
    {
        $this->setupUser();
        $this->assertFalse($this->userService->login('xxxxx', 'xxxxx'));
    }

    public function testUserPersistence()
    {
        $this->setupUser();
        $this->assertTrue($this->userService->login('test', 'qwerty'));

        $newUserService = new User($this->entityManager, $this->sessionManager);
        $this->assertEquals(1, $newUserService->getUser()->getId());
    }

    public function testGetView()
    {
        $this->setupUser();
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\User', $this->userService->getView());
    }
}
