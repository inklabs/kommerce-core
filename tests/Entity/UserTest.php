<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $user = new User;
        $user->setid(1);
        $user->setStatus(User::STATUS_ACTIVE);
        $user->setEmail('test@example.com');
        $user->setUsername('test');
        $user->setPassword('xxxx');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setLastLogin(new \DateTime);
        $user->addRole(new UserRole);
        $user->addToken(new UserToken);
        $user->addLogin(new UserLogin);
        $user->addOrder(new Order(new Cart, new Service\Pricing));

        $this->assertEquals(1, $user->getId());
        $this->assertEquals(User::STATUS_ACTIVE, $user->getStatus());
        $this->assertTrue($user->isActive());
        $this->assertEquals('test@example.com', $user->getEmail());
        $this->assertEquals('test', $user->getUsername());
        $this->assertEquals('John', $user->getFirstName());
        $this->assertEquals('Doe', $user->getLastName());
        $this->assertEquals(0, $user->getTotalLogins());
        $this->assertTrue($user->getLastLogin() > 0);
        $this->assertTrue($user->getRoles()[0] instanceof UserRole);
        $this->assertTrue($user->getTokens()[0] instanceof UserToken);
        $this->assertTrue($user->getLogins()[0] instanceof UserLogin);
        $this->assertTrue($user->getOrders()[0] instanceof Order);
        $this->assertTrue($user->getView() instanceof View\User);
    }

    public function testVerifyPassword()
    {
        $user = new User;
        $user->setPassword('qwerty');
        $this->assertTrue($user->verifyPassword('qwerty'));
        $this->assertFalse($user->verifyPassword('wrong'));
    }

    public function testIncrementTotalLogins()
    {
        $user = new User;
        $user->incrementTotalLogins();
        $this->assertEquals(1, $user->getTotalLogins());
        $this->assertTrue($user->getLastLogin() > 0);
    }
}
