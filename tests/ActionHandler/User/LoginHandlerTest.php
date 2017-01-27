<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Exception\UserLoginException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class LoginHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        UserLogin::class,
        UserRole::class,
        UserToken::class,
        Cart::class,
        TaxRate::class,
    ];

    public function testLoginSucceeds()
    {
        $password = 'password1';
        $user = $this->dummyData->getUser();
        $user->setPassword($password);
        $this->persistEntityAndFlushClear($user);
        $command = new LoginCommand(
            $user->getEmail(),
            $password,
            self::IP4
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $user = $this->getRepositoryFactory()->getUserRepository()->findOneById(
            $user->getId()
        );
        $login = $user->getUserLogins()[0];
        $this->assertSame(1, $user->getTotalLogins());
        $this->assertSame(self::IP4, $login->getIp4());
    }

    public function testLoginFailsWithWrongEmail()
    {
        $user = $this->dummyData->getUser();
        $this->persistEntityAndFlushClear($user);
        $command = new LoginCommand(
            'wrong-email@example.com',
            'password1',
            self::IP4
        );

        $this->setExpectedException(
            UserLoginException::class,
            'User not found',
            0
        );

        $this->dispatchCommand($command);
    }

    public function testLoginFailsWithWrongPassword()
    {
        $user = $this->dummyData->getUser();
        $user->setPassword('password1');
        $this->persistEntityAndFlushClear($user);
        $command = new LoginCommand(
            $user->getEmail(),
            'password2',
            self::IP4
        );

        $this->setExpectedException(
            UserLoginException::class,
            'User password not valid',
            2
        );

        $this->dispatchCommand($command);
    }

    public function testLoginFailsWithInactiveUser()
    {
        $user = $this->dummyData->getUser();
        $user->setStatus(UserStatusType::inactive());
        $this->persistEntityAndFlushClear($user);
        $command = new LoginCommand(
            $user->getEmail(),
            'password1',
            self::IP4
        );

        $this->setExpectedException(
            UserLoginException::class,
            'User not active',
            1
        );

        $this->dispatchCommand($command);
    }
}
