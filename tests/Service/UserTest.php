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
        $this->entityManager->clear();
    }

    public function testUserDoesNotExist()
    {
        $user = $this->userService->find(0);
        $this->assertSame(null, $user);
    }

    public function testUserExists()
    {
        $user = $this->userService->find(1);
        $this->assertSame(1, $user->id);
    }

    public function testUserLoginWithUsername()
    {
        $this->assertTrue($this->userService->login('test', 'qwerty', '127.0.0.1'));

        $this->entityManager->clear();

        /* @var Entity\User $user */
        $user = $this->entityManager->getRepository('kommerce:User')
            ->find(1);

        $this->assertSame(1, $user->getTotalLogins());
        $this->assertSame(Entity\UserLogin::RESULT_SUCCESS, $user->getLogins()[0]->getResult());
    }

    public function testUserLoginWithWrongPassword()
    {
        $this->assertFalse($this->userService->login('test', 'xxxxx', '127.0.0.1'));

        $this->entityManager->clear();

        /* @var Entity\User $user */
        $user = $this->entityManager->getRepository('kommerce:User')
            ->find(1);

        $this->assertSame(0, $user->getTotalLogins());
        $this->assertSame(Entity\UserLogin::RESULT_FAIL, $user->getLogins()[0]->getResult());
    }

    public function testUserLoginWithWrongUsername()
    {
        $this->assertFalse($this->userService->login('xxxxx', 'xxxxx', '127.0.0.1'));
    }

    public function testLogout()
    {
        $this->userService->login('test', 'qwerty', '127.0.0.1');

        $this->userService->logout();

        $this->assertSame(null, $this->userService->getUser());

    }

    public function testUserPersistence()
    {
        $this->assertTrue($this->userService->login('test', 'qwerty', '127.0.0.1'));

        $this->entityManager->clear();

        $newUserService = new User($this->entityManager, $this->sessionManager);
        $this->assertSame(1, $newUserService->getUser()->getId());
    }
}
