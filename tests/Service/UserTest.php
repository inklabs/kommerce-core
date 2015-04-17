<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\tests\Helper;

class UserTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\User */
    protected $mockUserRepository;

    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    /** @var User */
    protected $userService;
    protected $sessionManager;

    public function setUp()
    {
        $this->mockUserRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\User');
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockUserRepository);

        $this->sessionManager = new Lib\ArraySessionManager;
        $this->userService = new User($this->mockEntityManager, $this->sessionManager);
    }

    public function testFind()
    {
        $user = $this->getDummyUser();

        $this->mockUserRepository
            ->shouldReceive('find')
            ->andReturn($user);

        $viewUser = $this->userService->find(1);
        $this->assertTrue($viewUser instanceof View\User);
    }

    public function testFindNotFound()
    {
        $this->mockUserRepository
            ->shouldReceive('find')
            ->andReturn(null);

        $viewUser = $this->userService->find(0);
        $this->assertSame(null, $viewUser);
    }

    public function testUserLogin()
    {
        $user = $this->getDummyUser();

        $this->mockUserRepository
            ->shouldReceive('findOneByEmail')
            ->andReturn($user);

        $this->userServiceCallsSave($user);
        $this->userServiceCallsRecordLogin();

        $this->assertSame(0, $user->getTotalLogins());

        $loginResult = $this->userService->login('test@example.com', 'xxxx', '127.0.0.1');

        $this->assertSame(1, $user->getTotalLogins());
        $this->assertTrue($loginResult);
    }

    public function testUserLoginWithWrongPassword()
    {
        $user = $this->getDummyUser();

        $this->mockUserRepository
            ->shouldReceive('findOneByEmail')
            ->andReturn($user);

        $this->userServiceCallsSave($user);
        $this->userServiceCallsRecordLogin();

        $this->assertSame(0, $user->getTotalLogins());

        $loginResult = $this->userService->login('test@example.com', 'zzz', '127.0.0.1');

        $this->assertSame(0, $user->getTotalLogins());
        $this->assertFalse($loginResult);
    }

    public function testUserLoginWithWrongEmail()
    {
        $user = null;

        $this->mockUserRepository
            ->shouldReceive('findOneByEmail')
            ->andReturn($user);

        $this->userServiceCallsSave(null);
        $this->userServiceCallsRecordLogin();

        $loginResult = $this->userService->login('zzz@example.com', 'xxxx', '127.0.0.1');

        $this->assertFalse($loginResult);
    }

    public function testLogout()
    {
        $user = $this->getDummyUser();

        $this->mockUserRepository
            ->shouldReceive('findOneByEmail')
            ->andReturn($user);

        $this->userServiceCallsSave($user);
        $this->userServiceCallsRecordLogin();

        $loginResult = $this->userService->login('test@example.com', 'xxxx', '127.0.0.1');

        $this->assertTrue($loginResult);
        $this->assertTrue($this->userService->getUser() instanceof Entity\User);

        $this->userService->logout();

        $this->assertSame(null, $this->userService->getUser());
    }

    public function xtestUserPersistence()
    {
        $this->assertTrue($this->userService->login('test@example.com', 'qwerty', '127.0.0.1'));

        $this->entityManager->clear();

        $newUserService = new User($this->entityManager, $this->sessionManager);
        $this->assertSame(1, $newUserService->getUser()->getId());
    }

    public function xtestGetAllUsers()
    {
        $this->mockUserRepository
            ->shouldReceive('getAllUsers')
            ->andReturn([new Entity\User]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockUserRepository);

        $userService = new User($this->mockEntityManager, $this->sessionManager);

        $users = $userService->getAllUsers();
        $this->assertTrue($users[0] instanceof View\User);
    }

    public function xtestAllGetUsersByIds()
    {
        $this->mockUserRepository
            ->shouldReceive('getAllUsersByIds')
            ->andReturn([new Entity\User]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockUserRepository);

        $userService = new User($this->mockEntityManager, $this->sessionManager);

        $users = $userService->getAllUsersByIds([1]);
        $this->assertTrue($users[0] instanceof View\User);
    }

    private function userServiceCallsSave(Entity\User $user = null)
    {
        $this->mockEntityManager
            ->shouldReceive('detach')
            ->andReturnUndefined();

        $this->mockEntityManager
            ->shouldReceive('merge')
            ->andReturn($user);
    }

    private function userServiceCallsRecordLogin()
    {
        $this->mockEntityManager
            ->shouldReceive('persist')
            ->andReturnUndefined();

        $this->mockEntityManager
            ->shouldReceive('flush')
            ->andReturnUndefined();
    }
}
