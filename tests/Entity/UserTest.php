<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;
use Symfony\Component\Validator\Validation;

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

        $orderItem = new OrderItem(new Product, 1, new Price);
        $order = new Order([$orderItem], new CartTotal);

        $user->addOrder($order);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($user));
        $this->assertSame(1, $user->getId());
        $this->assertSame(User::STATUS_ACTIVE, $user->getStatus());
        $this->assertSame('Active', $user->getStatusText());
        $this->assertTrue($user->isActive());
        $this->assertSame('test@example.com', $user->getEmail());
        $this->assertSame('test', $user->getUsername());
        $this->assertSame('John', $user->getFirstName());
        $this->assertSame('Doe', $user->getLastName());
        $this->assertSame(0, $user->getTotalLogins());
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
        $this->assertSame(1, $user->getTotalLogins());
        $this->assertTrue($user->getLastLogin() > 0);
    }

    public function testHasRoles()
    {
        $adminRole = new UserRole;
        $adminRole->setname('admin');

        $user = new User;
        $user->addRole($adminRole);

        $this->assertTrue($user->hasRoles(['admin']));
        $this->assertFalse($user->hasRoles(['developer']));
    }
}
