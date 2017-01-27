<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
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

    public function testHandle()
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
        $this->assertSame(self::IP4, $login->getIp4());
    }
}
