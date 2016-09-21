<?php
namespace inklabs\kommerce\Service;

use DateTime;
use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use inklabs\kommerce\Event\ResetPasswordEvent;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Exception\UserLoginException;
use inklabs\kommerce\tests\Helper\Entity\DummyData;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class UserServiceTest extends ServiceTestCase
{
    /** @var UserRepositoryInterface|\Mockery\Mock */
    protected $userRepository;

    /** @var UserLoginRepositoryInterface|\Mockery\Mock */
    protected $userLoginRepository;

    /** @var UserTokenRepositoryInterface|\Mockery\Mock */
    protected $userTokenRepository;

    /** @var FakeEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var UserService */
    protected $userService;

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->mockRepository->getUserRepository();
        $this->userLoginRepository = $this->mockRepository->getUserLoginRepository();
        $this->userTokenRepository = $this->mockRepository->getUserTokenRepository();
        $this->fakeEventDispatcher = new FakeEventDispatcher;

        $this->userService = new UserService(
            $this->userRepository,
            $this->userLoginRepository,
            $this->userTokenRepository,
            $this->fakeEventDispatcher
        );
    }

    public function testCRUD()
    {
        $this->executeServiceCRUD(
            $this->userService,
            $this->userRepository,
            $this->dummyData->getUser()
        );
    }

    public function testFind()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneById')
            ->with($user1->getId())
            ->andReturn($user1)
            ->once();

        $user = $this->userService->findOneById(
            $user1->getId()
        );

        $this->assertEntitiesEqual($user1, $user);
    }

    public function testFindOneByEmail()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneByEmail')
            ->with($user1->getEmail())
            ->andReturn($user1)
            ->once();

        $user = $this->userService->findOneByEmail(
            $user1->getEmail()
        );

        $this->assertEntitiesEqual($user1, $user);
    }

    public function testUserLogin()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneByEmail')
            ->with($user1->getEmail())
            ->andReturn($user1)
            ->once();

        $this->assertSame(0, $user1->getTotalLogins());

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $loginUser = $this->userService->login($user1->getEmail(), 'password1', self::IP4);

        $this->assertEntitiesEqual($user1, $loginUser);
        $this->assertSame(1, $user1->getTotalLogins());
    }

    public function testUserLoginWithWrongEmail()
    {
        $this->userRepository->shouldReceive('findOneByEmail')
            ->andThrow(EntityNotFoundException::class);

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $this->setExpectedException(
            UserLoginException::class,
            'User not found',
            0
        );

        $this->userService->login(self::EMAIL, 'password1', self::IP4);
    }

    public function testUserLoginWithInactiveUser()
    {
        $user1 = $this->dummyData->getUser();
        $user1->setStatus(UserStatusType::inactive());

        $this->userRepository->shouldReceive('findOneByEmail')
            ->andReturn($user1)
            ->once();

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $this->setExpectedException(
            UserLoginException::class,
            'User not active',
            1
        );

        $this->userService->login($user1->getEmail(), 'password1', self::IP4);
    }

    public function testUserLoginWithWrongPassword()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneByEmail')
            ->andReturn($user1)
            ->once();

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $this->setExpectedException(
            UserLoginException::class,
            'User password not valid',
            2
        );

        $this->userService->login($user1->getEmail(), 'wrongpassword', self::IP4);
    }

    public function testGetAllUsers()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('getAllUsers')
            ->andReturn([$user1])
            ->once();

        $users = $this->userService->getAllUsers();

        $this->assertEntitiesEqual($user1, $users[0]);
    }

    public function testAllGetUsersByIds()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('getAllUsersByIds')
            ->with([$user1->getId()], null)
            ->andReturn([$user1])
            ->once();

        $users = $this->userService->getAllUsersByIds([
            $user1->getId()
        ]);

        $this->assertEntitiesEqual($user1, $users[0]);
    }

    public function testLoginWithTokenThrowsExceptionWhenUserNotFound()
    {
        $this->userRepository->shouldReceive('findOneByEmail')
            ->andThrow(EntityNotFoundException::class);

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $this->setExpectedException(
            UserLoginException::class,
            'User not found'
        );

        $this->userService->loginWithToken(self::EMAIL, 'token123', self::IP4);
    }

    public function testLoginWithTokenThrowsExceptionWhenUserNotActive()
    {
        $user1 = $this->dummyData->getUser();
        $user1->setStatus(UserStatusType::inactive());
        $this->userRepository->shouldReceive('findOneByEmail')
            ->andReturn($user1)
            ->once();

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $this->setExpectedException(
            UserLoginException::class,
            'User not active'
        );

        $this->userService->loginWithToken($user1->getEmail(), 'token123', self::IP4);
    }

    public function testLoginWithTokenThrowsExceptionWhenTokenNotFound()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneByEmail')
            ->andReturn($user1)
            ->once();

        $token = 'token123';
        $this->userTokenRepository->shouldReceive('findLatestOneByUserId')
            ->andThrow(EntityNotFoundException::class);

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $this->setExpectedException(
            UserLoginException::class,
            'Token not found'
        );

        $this->userService->loginWithToken($user1->getEmail(), $token, self::IP4);
    }

    public function testLoginWithTokenThrowsExceptionWhenTokenNotValid()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneByEmail')
            ->andReturn($user1)
            ->once();

        $userToken = $this->dummyData->getUserToken($user1);
        $this->userTokenRepository->shouldReceive('findLatestOneByUserId')
            ->with($user1->getId())
            ->andReturn($userToken)
            ->once();

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $this->setExpectedException(
            UserLoginException::class,
            'Token not valid'
        );

        $this->userService->loginWithToken($user1->getEmail(), 'wrongtoken123', self::IP4);
    }

    public function testLoginWithTokenThrowsExceptionWhenTokenExpired()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneByEmail')
            ->andReturn($user1)
            ->once();

        $userToken = $this->dummyData->getUserToken($user1, new DateTime('-1 hour'));
        $this->userTokenRepository->shouldReceive('findLatestOneByUserId')
            ->with($user1->getId())
            ->andReturn($userToken)
            ->once();

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $this->setExpectedException(
            UserLoginException::class,
            'Token expired'
        );

        $this->userService->loginWithToken($user1->getEmail(), DummyData::USER_TOKEN_STRING, self::IP4);
    }

    public function testLoginWithTokenSucceeds()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneByEmail')
            ->andReturn($user1)
            ->once();

        $userToken = $this->dummyData->getUserToken($user1);
        $this->userTokenRepository->shouldReceive('findLatestOneByUserId')
            ->with($user1->getId())
            ->andReturn($userToken)
            ->once();

        $this->userLoginRepository->shouldReceive('create')
            ->once();

        $this->userService->loginWithToken($user1->getEmail(), DummyData::USER_TOKEN_STRING, self::IP4);
    }

    public function testRequestPasswordResetToken()
    {
        $user1 = $this->dummyData->getUser();

        $ip4 = self::IP4;
        $userAgent = self::USER_AGENT;

        $this->userRepository->shouldReceive('findOneByEmail')
            ->andReturn($user1)
            ->once();

        $this->userTokenRepository->shouldReceive('create')
            ->once();

        $this->userService->requestPasswordResetToken($user1->getEmail(), $userAgent, $ip4);

        /** @var ResetPasswordEvent $event */
        $event = $this->fakeEventDispatcher->getDispatchedEvents(ResetPasswordEvent::class)[0];
        $this->assertTrue($event instanceof ResetPasswordEvent);
        $this->assertSame($user1->getId(), $event->getUserId());
        $this->assertSame($user1->getEmail(), $event->getEmail());
        $this->assertSame($user1->getFullName(), $event->getFullName());
        $this->assertSame(40, strlen($event->getToken()));
    }

    public function testChangePassword()
    {
        $user1 = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneById')
            ->with($user1->getid())
            ->andReturn($user1)
            ->once();

        $this->userRepository->shouldReceive('update')
            ->once();

        $newPassword = 'newpassword';
        $this->userService->changePassword($user1->getId(), $newPassword);

        $this->assertTrue($user1->verifyPassword($newPassword));
    }
}
