<?php
namespace inklabs\kommerce\Service;

use DateTime;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use inklabs\kommerce\Exception\UserLoginException;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\tests\Helper\Entity\DummyData;
use inklabs\kommerce\Lib\Event\LoggingEventDispatcher;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class UserServiceTest extends ServiceTestCase
{
    /** @var UserRepositoryInterface */
    protected $userRepository;

    /** @var UserLoginRepositoryInterface */
    protected $userLoginRepository;

    /** @var UserTokenRepositoryInterface */
    protected $userTokenRepository;

    /** @var LoggingEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var UserService */
    protected $userService;

    protected $metaDataClassNames = [
        Cart::class,
        TaxRate::class,
        User::class,
        UserLogin::class,
        UserRole::class,
        UserToken::class,
    ];

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->getRepositoryFactory()->getUserRepository();
        $this->userLoginRepository = $this->getRepositoryFactory()->getUserLoginRepository();
        $this->userTokenRepository = $this->getRepositoryFactory()->getUserTokenRepository();
        $this->fakeEventDispatcher = new LoggingEventDispatcher(new EventDispatcher());

        $this->userService = new UserService(
            $this->userRepository,
            $this->userLoginRepository,
            $this->userTokenRepository,
            $this->fakeEventDispatcher
        );
    }

    public function testLoginWithTokenThrowsExceptionWhenUserNotFound()
    {
        // Given

        // When
        try {
            $this->userService->loginWithToken(self::EMAIL, 'token123', self::IP4);
            $this->fail();
        } catch (UserLoginException $e) {
            $this->assertEquals("User not found", $e->getMessage());
        }

        // Then
        $this->entityManager->clear();
        $userLogins = $this->getRepositoryFactory()->getUserLoginRepository()->getAllUserLogins();
        $lastUserLogin = $userLogins[0];
        $this->assertEquals(self::EMAIL, $lastUserLogin->getEmail());
        $this->assertEquals(self::IP4, $lastUserLogin->getIp4());
        $this->assertTrue($lastUserLogin->getResult()->isFail());
    }

    public function testLoginWithTokenThrowsExceptionWhenUserNotActive()
    {
        // Given
        $user1 = $this->dummyData->getUser();
        $user1->setStatus(UserStatusType::inactive());
        $this->persistEntityAndFlushClear($user1);

        // When
        try {
            $this->userService->loginWithToken($user1->getEmail(), 'token123', self::IP4);
            $this->fail();
        } catch (UserLoginException $e) {
            $this->assertEquals("User not active", $e->getMessage());
        }

        // Then
        $this->entityManager->clear();
        $userLogins = $this->getRepositoryFactory()->getUserLoginRepository()->getAllUserLogins();
        $lastUserLogin = $userLogins[0];
        $this->assertEquals($user1->getEmail(), $lastUserLogin->getEmail());
        $this->assertEquals(self::IP4, $lastUserLogin->getIp4());
        $this->assertTrue($lastUserLogin->getResult()->isFail());
        $this->assertEntitiesEqual($user1, $lastUserLogin->getUser());
    }

    public function testLoginWithTokenThrowsExceptionWhenTokenNotFound()
    {
        // Given
        $user1 = $this->dummyData->getUser();
        $this->persistEntityAndFlushClear($user1);

        // When
        try {
            $this->userService->loginWithToken($user1->getEmail(), 'token123', self::IP4);
            $this->fail();
        } catch (UserLoginException $e) {
            $this->assertEquals("Token not found", $e->getMessage());
        }

        // Then
        $this->entityManager->clear();
        $userLogins = $this->getRepositoryFactory()->getUserLoginRepository()->getAllUserLogins();
        $lastUserLogin = $userLogins[0];
        $this->assertEquals($user1->getEmail(), $lastUserLogin->getEmail());
        $this->assertEquals(self::IP4, $lastUserLogin->getIp4());
        $this->assertTrue($lastUserLogin->getResult()->isFail());
        $this->assertEntitiesEqual($user1, $lastUserLogin->getUser());
    }

    public function testLoginWithTokenThrowsExceptionWhenTokenNotValid()
    {
        // Given
        $user1 = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken($user1);
        $this->persistEntityAndFlushClear([
            $user1,
            $userToken,
        ]);

        // When
        try {
            $this->userService->loginWithToken($user1->getEmail(), 'wrongtoken123', self::IP4);
            $this->fail();
        } catch (UserLoginException $e) {
            $this->assertEquals("Token not valid", $e->getMessage());
        }

        // Then
        $this->entityManager->clear();
        $userLogins = $this->getRepositoryFactory()->getUserLoginRepository()->getAllUserLogins();
        $lastUserLogin = $userLogins[0];
        $this->assertEquals($user1->getEmail(), $lastUserLogin->getEmail());
        $this->assertEquals(self::IP4, $lastUserLogin->getIp4());
        $this->assertTrue($lastUserLogin->getResult()->isFail());
        $this->assertEntitiesEqual($user1, $lastUserLogin->getUser());
    }

    public function testLoginWithTokenThrowsExceptionWhenTokenExpired()
    {
        // Given
        $user1 = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken($user1, dummyData::USER_TOKEN_STRING, new DateTime('-1 hour'));

        $this->persistEntityAndFlushClear([
            $user1,
            $userToken,
        ]);

        // When
        try {
            $this->userService->loginWithToken($user1->getEmail(), DummyData::USER_TOKEN_STRING, self::IP4);
            $this->fail();
        } catch (UserLoginException $e) {
            $this->assertEquals("Token expired", $e->getMessage());
        }

        // Then
        $this->entityManager->clear();
        $userLogins = $this->getRepositoryFactory()->getUserLoginRepository()->getAllUserLogins();
        $lastUserLogin = $userLogins[0];
        $this->assertEquals($user1->getEmail(), $lastUserLogin->getEmail());
        $this->assertEquals(self::IP4, $lastUserLogin->getIp4());
        $this->assertTrue($lastUserLogin->getResult()->isFail());
        $this->assertEntitiesEqual($user1, $lastUserLogin->getUser());
    }
}
