<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ResetPasswordCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Event\ResetPasswordEvent;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ResetPasswordHandlerTest extends ActionTestCase
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
        $command = new ResetPasswordCommand(
            $user->getEmail(),
            self::IP4,
            self::USER_AGENT
        );

        $this->dispatchCommand($command);

        /** @var ResetPasswordEvent $event */
        $event = $this->getDispatchedEvents()[0];
        $this->assertTrue($event instanceof ResetPasswordEvent);
        $this->assertSame($user->getId()->getHex(), $event->getUserId()->getHex());
        $this->assertSame($user->getEmail(), $event->getEmail());
        $this->assertSame($user->getFullName(), $event->getFullName());
        $this->assertSame(40, strlen($event->getToken()));
    }
}
