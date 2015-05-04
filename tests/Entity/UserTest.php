<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Service;
use Symfony\Component\Validator\Validation;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $userLogin = new UserLogin;
        $userLogin->setResult(UserLogin::RESULT_SUCCESS);

        $user = new User;
        $user->setExternalId('5');
        $user->setStatus(User::STATUS_ACTIVE);
        $user->setEmail('test@example.com');
        $user->setPassword('xxxx');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setLastLogin(new \DateTime);
        $user->addRole(new UserRole);
        $user->addToken(new UserToken);
        $user->addLogin($userLogin);

        $orderItem = new OrderItem;
        $orderItem->setProduct(new Product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice(new Price);

        $order = new Order;
        $order->addOrderItem($orderItem);
        $order->setTotal(new CartTotal);

        $user->addOrder($order);
        $user->setCart(new Cart);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($user));
        $this->assertSame(User::STATUS_ACTIVE, $user->getStatus());
        $this->assertSame('Active', $user->getStatusText());
        $this->assertSame('5', $user->getExternalId());
        $this->assertTrue($user->isActive());
        $this->assertSame('test@example.com', $user->getEmail());
        $this->assertSame('John', $user->getFirstName());
        $this->assertSame('Doe', $user->getLastName());
        $this->assertSame(1, $user->getTotalLogins());
        $this->assertTrue($user->getLastLogin() > 0);
        $this->assertTrue($user->getRoles()[0] instanceof UserRole);
        $this->assertTrue($user->getTokens()[0] instanceof UserToken);
        $this->assertTrue($user->getLogins()[0] instanceof UserLogin);
        $this->assertTrue($user->getOrders()[0] instanceof Order);
        $this->assertTrue($user->getCart() instanceof Cart);
        $this->assertTrue($user->getView() instanceof View\User);
    }

    public function testSetPasswordEmpty()
    {
        $user = new User;
        $user->setPassword();
    }

    public function testLoadFromView()
    {
        $user = new User;
        $user->loadFromView(new View\User(new User));
        $this->assertTrue($user instanceof User);
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
        $adminRole->setName('admin');

        $user = new User;
        $user->addRole($adminRole);

        $this->assertTrue($user->hasRoles(['admin']));
        $this->assertFalse($user->hasRoles(['developer']));
    }
}
