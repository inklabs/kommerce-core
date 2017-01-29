<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginWithTokenCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class LoginWithTokenHandlerTest extends ActionTestCase
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
        $user = $this->dummyData->getUser();
        $token = 'token123';
        $userToken = $this->dummyData->getUserToken($user, $token);
        $this->persistEntityAndFlushClear([$user, $userToken]);
        $command = new LoginWithTokenCommand(
            $user->getEmail(),
            $token,
            self::IP4
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $user = $this->getRepositoryFactory()->getUserRepository()->findOneById(
            $user->getId()
        );
        $login = $user->getUserLogins()[0];
        $this->assertSame(1, $user->getTotalLogins());
        $this->assertEntitiesEqual($userToken, $login->getUserToken());
        $this->assertSame(self::IP4, $login->getIp4());
    }
}
