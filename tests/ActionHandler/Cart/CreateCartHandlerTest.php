<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\CreateCartCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCartHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Cart::class,
        User::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $this->persistEntityAndFlushClear($user);
        $command = new CreateCartCommand(
            self::IP4,
            $user->getId()->getHex(),
            self::SESSION_ID
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $command->getCartId()
        );
        $this->assertEntitiesEqual($user, $cart->getUser());
        $this->assertSame(self::IP4, $cart->getIp4());
        $this->assertSame(self::SESSION_ID, $cart->getSessionId());
    }
}
