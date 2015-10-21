<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserLoginRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserTokenRepository;

class UserServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeUserRepository */
    protected $userRepository;

    /** @var FakeUserLoginRepository */
    protected $userLoginRepository;

    /** @var FakeUserTokenRepository */
    protected $userTokenRepository;

    /** @var FakeEventDispatcher */
    protected $eventDispatcher;

    /** @var UserService */
    protected $userService;

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = new FakeUserRepository;
        $this->userLoginRepository = new FakeUserLoginRepository;
        $this->userTokenRepository = new FakeUserTokenRepository;
        $this->eventDispatcher = new FakeEventDispatcher;

        $this->userService = new UserService(
            $this->userRepository,
            $this->userLoginRepository,
            $this->userTokenRepository,
            $this->eventDispatcher
        );
    }

    public function testCreate()
    {
        $user = $this->dummyData->getUser('test1@example.com');
        $this->userService->create($user);
        $this->assertTrue($user instanceof User);
    }

    public function testUpdate()
    {
        $newName = 'New Name';
        $user = $this->dummyData->getUser();
        $this->assertNotSame($newName, $user->getFirstName());

        $user->setFirstName($newName);
        $this->userService->update($user);
        $this->assertSame($newName, $user->getFirstName());
    }

    public function testFind()
    {
        $this->userRepository->create(new User);
        $user = $this->userService->findOneById(1);
        $this->assertTrue($user instanceof User);
    }

    public function testFindOneByEmail()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $user = $this->userService->findOneByEmail('test1@example.com');
        $this->assertTrue($user instanceof User);
    }

    public function testUserLogin()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $this->assertSame(0, $user->getTotalLogins());

        $loginUser = $this->userService->login('test1@example.com', 'xxxx', '127.0.0.1');

        $this->assertSame(1, $user->getTotalLogins());
        $this->assertTrue($loginUser instanceof User);
    }

    /**
     * @expectedException \inklabs\kommerce\Service\UserLoginException
     * @expectedExceptionCode 0
     * @expectedExceptionMessage User not found
     */
    public function testUserLoginWithWrongEmail()
    {
        $this->userService->login('zzz@example.com', 'xxxx', '127.0.0.1');
    }

    /**
     * @expectedException \inklabs\kommerce\Service\UserLoginException
     * @expectedExceptionCode 1
     * @expectedExceptionMessage User not active
     */
    public function testUserLoginWithInactiveUser()
    {
        $user = $this->dummyData->getUser();
        $user->setStatus(User::STATUS_INACTIVE);
        $this->userRepository->create($user);

        $this->userService->login('test1@example.com', 'xxxx', '127.0.0.1');
    }

    /**
     * @expectedException \inklabs\kommerce\Service\UserLoginException
     * @expectedExceptionCode 2
     * @expectedExceptionMessage User password not valid
     */
    public function testUserLoginWithWrongPassword()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $this->userService->login('test1@example.com', 'zzz', '127.0.0.1');
    }

    public function testGetAllUsers()
    {
        $users = $this->userService->getAllUsers();
        $this->assertTrue($users[0] instanceof User);
    }

    public function testAllGetUsersByIds()
    {
        $users = $this->userService->getAllUsersByIds([1]);
        $this->assertTrue($users[0] instanceof User);
    }
}
