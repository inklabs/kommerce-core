<?php
namespace inklabs\kommerce\Service;

use DateTime;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Event\ResetPasswordEvent;
use inklabs\kommerce\Exception\UserLoginException;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserLoginRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserTokenRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class UserServiceTest extends ServiceTestCase
{
    /** @var FakeUserRepository */
    protected $userRepository;

    /** @var FakeUserLoginRepository */
    protected $userLoginRepository;

    /** @var FakeUserTokenRepository */
    protected $userTokenRepository;

    /** @var FakeEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var UserService */
    protected $userService;

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = new FakeUserRepository;
        $this->userLoginRepository = new FakeUserLoginRepository;
        $this->userTokenRepository = new FakeUserTokenRepository;
        $this->fakeEventDispatcher = new FakeEventDispatcher;

        $this->userService = new UserService(
            $this->userRepository,
            $this->userLoginRepository,
            $this->userTokenRepository,
            $this->fakeEventDispatcher
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

        $loginUser = $this->userService->login('test1@example.com', 'password1', '127.0.0.1');

        $this->assertSame(1, $user->getTotalLogins());
        $this->assertTrue($loginUser instanceof User);
    }

    public function testUserLoginWithWrongEmail()
    {
        $this->setExpectedException(
            UserLoginException::class,
            'User not found',
            0
        );

        $this->userService->login('zzz@example.com', 'password1', '127.0.0.1');
    }

    public function testUserLoginWithInactiveUser()
    {
        $user = $this->dummyData->getUser();
        $user->setStatus(UserStatusType::inactive());
        $this->userRepository->create($user);

        $this->setExpectedException(
            UserLoginException::class,
            'User not active',
            1
        );

        $this->userService->login('test1@example.com', 'password1', '127.0.0.1');
    }

    public function testUserLoginWithWrongPassword()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $this->setExpectedException(
            UserLoginException::class,
            'User password not valid',
            2
        );

        $this->userService->login('test1@example.com', 'wrongpassword', '127.0.0.1');
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

    public function testLoginWithTokenThrowsExceptionWhenUserNotFound()
    {
        $this->setExpectedException(
            UserLoginException::class,
            'User not found'
        );

        $this->userService->loginWithToken('test@example.com', 'token123', '127.0.0.1');
    }

    public function testLoginWithTokenThrowsExceptionWhenUserNotActive()
    {
        $user = $this->dummyData->getUser();
        $user->setStatus(UserStatusType::inactive());
        $this->userRepository->create($user);

        $this->setExpectedException(
            UserLoginException::class,
            'User not active'
        );

        $this->userService->loginWithToken($user->getEmail(), 'token123', '127.0.0.1');
    }

    public function testLoginWithTokenThrowsExceptionWhenTokenNotFound()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $this->setExpectedException(
            UserLoginException::class,
            'Token not found'
        );

        $this->userService->loginWithToken($user->getEmail(), 'token123', '127.0.0.1');
    }

    public function testLoginWithTokenThrowsExceptionWhenTokenNotValid()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $userToken = $this->dummyData->getUserToken();
        $userToken->setUser($user);
        $this->userTokenRepository->create($userToken);

        $this->setExpectedException(
            UserLoginException::class,
            'Token not valid'
        );

        $this->userService->loginWithToken($user->getEmail(), 'token123', '127.0.0.1');
    }

    public function testLoginWithTokenThrowsExceptionWhenTokenExpired()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $userToken = $this->dummyData->getUserToken();
        $userToken->setToken('token999');
        $userToken->setExpires(new DateTime('-1 day'));
        $userToken->setUser($user);
        $this->userTokenRepository->create($userToken);

        $this->setExpectedException(
            UserLoginException::class,
            'Token expired'
        );

        $this->userService->loginWithToken($user->getEmail(), 'token999', '127.0.0.1');
    }

    public function testLoginWithTokenSucceeds()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $userToken = $this->dummyData->getUserToken();
        $userToken->setToken('token999');
        $userToken->setExpires(new DateTime('+1 hour'));
        $userToken->setUser($user);
        $this->userTokenRepository->create($userToken);

        $this->userService->loginWithToken($user->getEmail(), 'token999', '127.0.0.1');

        $userLogin = $this->userLoginRepository->findOneById(1);
        $this->assertTrue($userLogin instanceof UserLogin);
    }

    public function testRequestPasswordResetToken()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $ip4 = '127.0.0.1';
        $userAgent = 'UserAgent String';

        $this->userService->requestPasswordResetToken($user->getEmail(), $userAgent, $ip4);

        $userToken = $this->userTokenRepository->findOneById(1);

        $this->assertTrue($userToken instanceof UserToken);
        $this->assertSame($ip4, $userToken->getIp4());
        $this->assertSame($userAgent, $userToken->getUserAgent());
        $this->assertSame($user, $userToken->getUser());
        $this->assertCloseTo(3600, $userToken->getExpires()->getTimestamp() - $userToken->getCreated()->getTimestamp());
        $this->assertTrue($userToken->getType()->isInternal());

        /** @var ResetPasswordEvent $event */
        $event = $this->fakeEventDispatcher->getDispatchedEvents(ResetPasswordEvent::class)[0];
        $this->assertTrue($event instanceof ResetPasswordEvent);
        $this->assertSame($user->getId(), $event->getUserId());
        $this->assertSame($user->getEmail(), $event->getEmail());
        $this->assertSame($user->getFullName(), $event->getFullName());
        $this->assertSame(40, strlen($event->getToken()));
    }

    public function testChangePassword()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);
        $password = 'newpassword';

        $this->userService->changePassword($user->getId(), $password);

        $testUser = $this->userRepository->findOneById($user->getId());
        $this->assertSame(true, $testUser->verifyPassword($password));
    }
}
