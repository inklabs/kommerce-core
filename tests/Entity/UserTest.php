<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\Event\PasswordChangedEvent;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UserTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $user = new User;

        $this->assertTrue($user->getStatus()->isActive());
        $this->assertSame(null, $user->getExternalId());
        $this->assertSame(null, $user->getEmail());
        $this->assertSame(null, $user->getFirstName());
        $this->assertSame(null, $user->getLastName());
        $this->assertSame(null, $user->getCart());
        $this->assertSame(null, $user->getLastLogin());
        $this->assertSame(0, $user->getTotalLogins());
        $this->assertSame(0, count($user->getUserRoles()));
        $this->assertSame(0, count($user->getUserTokens()));
        $this->assertSame(0, count($user->getUserLogins()));
        $this->assertSame(0, count($user->getOrders()));
    }

    public function testCreate()
    {
        $userRole = $this->dummyData->getUserRole();
        $userStatus = $this->dummyData->getUserStatusType();

        $order = $this->dummyData->getOrder();
        $cart = $this->dummyData->getCart();

        $user = new User;
        $user->setExternalId('5');
        $user->setStatus($userStatus);
        $user->setEmail('test@example.com');
        $user->setPassword('password1');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->addUserRole($userRole);
        $user->addOrder($order);
        $user->setCart($cart);

        $userLogin = $this->dummyData->getUserLogin($user);
        $userToken = $this->dummyData->getUserToken($user);

        $user->incrementTotalLogins();

        $this->assertEntityValid($user);
        $this->assertSame($userStatus, $user->getStatus());
        $this->assertSame('5', $user->getExternalId());
        $this->assertSame('test@example.com', $user->getEmail());
        $this->assertSame('John', $user->getFirstName());
        $this->assertSame('Doe', $user->getLastName());
        $this->assertSame(1, $user->getTotalLogins());
        $this->assertSame($userRole, $user->getUserRoles()[0]);
        $this->assertSame($userToken, $user->getUserTokens()[0]);
        $this->assertSame($userLogin, $user->getUserLogins()[0]);
        $this->assertSame($order, $user->getOrders()[0]);
        $this->assertSame($cart, $user->getCart());
        $this->assertTrue($user->getLastLogin()->getTimestamp() > 0);
    }

    public function testSetPasswordRaisesEvent()
    {
        $user = new User;
        $user->setEmail('john@example.com');
        $user->setPassword('Password1');
        $this->assertSame(0, count($user->releaseEvents()));

        $user->setId(1);
        $user->setPassword('NewPassword123');

        /** @var PasswordChangedEvent $event */
        $event = $user->releaseEvents()[0];
        $this->assertTrue($event instanceof PasswordChangedEvent);
        $this->assertSame($user->getId(), $event->getUserId());
        $this->assertSame($user->getEmail(), $event->getEmail());
        $this->assertSame($user->getFullName(), $event->getFullName());
    }

    public function testVerifyPassword()
    {
        $user = new User;
        $user->setPassword('qwerty1234');
        $this->assertTrue($user->verifyPassword('qwerty1234'));
        $this->assertFalse($user->verifyPassword('wrong1234'));
    }

    public function testIncrementTotalLogins()
    {
        $user = new User;
        $this->assertSame(null, $user->getLastLogin());

        $user->incrementTotalLogins();
        $this->assertSame(1, $user->getTotalLogins());
        $this->assertTrue($user->getLastLogin()->getTimestamp() > 0);
    }

    public function testHasRoles()
    {
        $adminRole = new UserRole;
        $adminRole->setName('admin');

        $user = new User;
        $user->addUserRole($adminRole);

        $this->assertTrue($user->hasUserRoles(['admin']));
        $this->assertFalse($user->hasUserRoles(['developer']));
    }
}
