<?php
namespace inklabs\kommerce\Service;

use DateTime;
use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Exception\UserLoginException;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\tests\Helper\Entity\DummyData;
use inklabs\kommerce\Lib\Event\LoggingEventDispatcher;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class UserServiceTest extends ServiceTestCase
{
    /** @var UserRepositoryInterface|\Mockery\Mock */
    protected $userRepository;

    /** @var UserLoginRepositoryInterface|\Mockery\Mock */
    protected $userLoginRepository;

    /** @var UserTokenRepositoryInterface|\Mockery\Mock */
    protected $userTokenRepository;

    /** @var LoggingEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var UserService */
    protected $userService;

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->mockRepository->getUserRepository();
        $this->userLoginRepository = $this->mockRepository->getUserLoginRepository();
        $this->userTokenRepository = $this->mockRepository->getUserTokenRepository();
        $this->fakeEventDispatcher = new LoggingEventDispatcher(new EventDispatcher());

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

        $userToken = $this->dummyData->getUserToken($user1, dummyData::USER_TOKEN_STRING, new DateTime('-1 hour'));
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
