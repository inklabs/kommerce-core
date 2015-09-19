<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserLoginRepository;

class UserTest extends Helper\DoctrineTestCase
{
    /** @var FakeUserRepository */
    protected $userRepository;

    /** @var FakeUserLoginRepository */
    protected $userLoginRepository;

    /** @var User */
    protected $userService;

    public function setUp()
    {
        $this->userRepository = new FakeUserRepository;
        $this->userLoginRepository = new FakeUserLoginRepository;

        $this->userService = new User(
            $this->userRepository,
            $this->userLoginRepository
        );
    }

    public function testCreate()
    {
        $user = $this->getDummyUser('test1@example.com');
        $this->userService->create($user);
        $this->assertTrue($user instanceof Entity\User);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $user = $this->getDummyUser();
        $this->assertNotSame($newName, $user->getFirstName());

        $user->setFirstName($newName);
        $this->userService->edit($user);
        $this->assertSame($newName, $user->getFirstName());
    }

    public function testFind()
    {
        $viewUser = $this->userService->find(1);
        $this->assertTrue($viewUser instanceof Entity\User);
    }

    public function testFindOneByEmail()
    {
        $viewUser = $this->userService->findOneByEmail('test1@example.com');
        $this->assertTrue($viewUser instanceof Entity\User);
    }

    public function testUserLogin()
    {
        $user = $this->getDummyUser();
        $this->userRepository->setReturnValue($user);

        $this->assertSame(0, $user->getTotalLogins());

        $loginUser = $this->userService->login('test@example.com', 'xxxx', '127.0.0.1');

        $this->assertSame(1, $user->getTotalLogins());
        $this->assertTrue($loginUser instanceof Entity\User);
    }

    /**
     * @expectedException \inklabs\kommerce\Service\UserLoginException
     * @expectedExceptionCode 0
     * @expectedExceptionMessage User not found
     */
    public function testUserLoginWithWrongEmail()
    {
        $this->userRepository->setReturnValue(null);
        $this->userService->login('zzz@example.com', 'xxxx', '127.0.0.1');
    }

    /**
     * @expectedException \inklabs\kommerce\Service\UserLoginException
     * @expectedExceptionCode 1
     * @expectedExceptionMessage User not active
     */
    public function testUserLoginWithInactiveUser()
    {
        $user = $this->getDummyUser();
        $user->setStatus(Entity\User::STATUS_INACTIVE);
        $this->userRepository->setReturnValue($user);

        $this->userService->login('test@example.com', 'xxxx', '127.0.0.1');
    }

    /**
     * @expectedException \inklabs\kommerce\Service\UserLoginException
     * @expectedExceptionCode 2
     * @expectedExceptionMessage User password not valid
     */
    public function testUserLoginWithWrongPassword()
    {
        $user = $this->getDummyUser();
        $this->userRepository->setReturnValue($user);

        $this->userService->login('test@example.com', 'zzz', '127.0.0.1');
    }

    public function testGetAllUsers()
    {
        $users = $this->userService->getAllUsers();
        $this->assertTrue($users[0] instanceof Entity\User);
    }

    public function testAllGetUsersByIds()
    {
        $users = $this->userService->getAllUsersByIds([1]);
        $this->assertTrue($users[0] instanceof Entity\User);
    }
}
