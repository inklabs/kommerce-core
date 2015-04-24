<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\EntityRepository\FakeUser;

class UserTest extends Helper\DoctrineTestCase
{
    /** @var FakeUser */
    protected $repository;

    /** @var User */
    protected $service;

    /** @var Lib\ArraySessionManager */
    protected $sessionManager;

    public function setUp()
    {
        $this->repository = new FakeUser;

        $this->sessionManager = new Lib\ArraySessionManager;
        $this->service = new User($this->repository, $this->sessionManager);
    }

    public function testFind()
    {
        $viewUser = $this->service->find(1);
        $this->assertTrue($viewUser instanceof View\User);
    }

    public function testFindNotFound()
    {
        $this->repository->setReturnValue(null);

        $viewUser = $this->service->find(0);
        $this->assertSame(null, $viewUser);
    }

    public function testUserLogin()
    {
        $user = $this->getDummyUser();
        $this->repository->setReturnValue($user);

        $this->assertSame(0, $user->getTotalLogins());

        $loginResult = $this->service->login('test@example.com', 'xxxx', '127.0.0.1');

        $this->assertSame(1, $user->getTotalLogins());
        $this->assertTrue($loginResult);
    }

    public function testUserLoginWithWrongPassword()
    {
        $user = $this->getDummyUser();
        $this->repository->setReturnValue($user);

        $this->assertSame(0, $user->getTotalLogins());

        $loginResult = $this->service->login('test@example.com', 'zzz', '127.0.0.1');

        $this->assertSame(0, $user->getTotalLogins());
        $this->assertFalse($loginResult);
    }

    public function testUserLoginWithWrongEmail()
    {
        $this->repository->setReturnValue(null);

        $loginResult = $this->service->login('zzz@example.com', 'xxxx', '127.0.0.1');

        $this->assertFalse($loginResult);
    }

    public function testLogout()
    {
        $user = $this->getDummyUser();
        $this->repository->setReturnValue($user);

        $loginResult = $this->service->login('test@example.com', 'xxxx', '127.0.0.1');

        $this->assertTrue($loginResult);
        $this->assertTrue($this->service->getUser() instanceof Entity\User);

        $this->service->logout();

        $this->assertSame(null, $this->service->getUser());
    }

    public function testGetAllUsers()
    {
        $users = $this->service->getAllUsers();
        $this->assertTrue($users[0] instanceof View\User);
    }

    public function testAllGetUsersByIds()
    {
        $users = $this->service->getAllUsersByIds([1]);
        $this->assertTrue($users[0] instanceof View\User);
    }
}
