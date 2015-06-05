<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUser;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserLogin;

class UserTest extends Helper\DoctrineTestCase
{
    /** @var FakeUser */
    protected $userRepository;

    /** @var FakeUserLogin */
    protected $userLoginRepository;

    /** @var User */
    protected $userService;

    public function setUp()
    {
        $this->userRepository = new FakeUser;
        $this->userLoginRepository = new FakeUserLogin;

        $this->userService = new User(
            $this->userRepository,
            $this->userLoginRepository
        );
    }

    public function testCreate()
    {
        $user = $this->getDummyUser();
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
        $this->assertTrue($viewUser instanceof View\User);
    }

    public function testFindNotFound()
    {
        $this->userRepository->setReturnValue(null);

        $viewUser = $this->userService->find(0);
        $this->assertSame(null, $viewUser);
    }

    public function testUserLogin()
    {
        $user = $this->getDummyUser();
        $this->userRepository->setReturnValue($user);

        $this->assertSame(0, $user->getTotalLogins());

        $loginUser = $this->userService->login('test@example.com', 'xxxx', '127.0.0.1');

        $this->assertSame(1, $user->getTotalLogins());
        $this->assertTrue($loginUser instanceof View\User);
    }

    /**
     * @expectedException \inklabs\kommerce\Service\UserLoginException
     * @expectedExceptionCode 0
     * @expectedExceptionMessage User not found
     */
    public function testUserLoginWithWrongEmail()
    {
        $this->userRepository->setReturnValue(null);

        $loginUser = $this->userService->login('zzz@example.com', 'xxxx', '127.0.0.1');
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

        $loginUser = $this->userService->login('test@example.com', 'xxxx', '127.0.0.1');
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

        $loginUser = $this->userService->login('test@example.com', 'zzz', '127.0.0.1');
    }

    public function testGetAllUsers()
    {
        $users = $this->userService->getAllUsers();
        $this->assertTrue($users[0] instanceof View\User);
    }

    public function testAllGetUsersByIds()
    {
        $users = $this->userService->getAllUsersByIds([1]);
        $this->assertTrue($users[0] instanceof View\User);
    }
}
