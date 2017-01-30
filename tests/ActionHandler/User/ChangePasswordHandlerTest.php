<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ChangePasswordCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Event\PasswordChangedEvent;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ChangePasswordHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        UserRole::class,
        UserToken::class,
        Cart::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $this->persistEntityAndFlushClear($user);
        $password = 'newPassword123';
        $command = new ChangePasswordCommand(
            $user->getId()->getHex(),
            $password
        );

        $this->dispatchCommand($command);

        /** @var PasswordChangedEvent $event */
        $event = $this->getDispatchedEvents()[0];
        $this->assertTrue($event instanceof PasswordChangedEvent);
        $this->assertSame($user->getId()->getHex(), $event->getUserId()->getHex());
        $this->assertSame($user->getEmail(), $event->getEmail());
        $this->assertSame($user->getFullName(), $event->getFullName());
    }
}
