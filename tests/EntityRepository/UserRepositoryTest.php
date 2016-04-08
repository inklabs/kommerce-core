<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class UserRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        User::class,
        UserLogin::class,
        UserToken::class,
        UserRole::class,
        Order::class,
        Cart::class,
        TaxRate::class,
    ];

    /** @var UserRepositoryInterface */
    protected $userRepository;

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->getRepositoryFactory()->getUserRepository();
    }

    private function setupUser()
    {
        $user = $this->dummyData->getUser();

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $user;
    }

    private function setupUserWithCart()
    {
        $user = $this->dummyData->getUser();

        $cart = $this->dummyData->getCart();
        $cart->setUser($user);

        $this->entityManager->persist($user);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $user;
    }

    public function testCRUD()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);
        $this->assertSame(1, $user->getId());

        $user->setFirstName('New First Name');
        $this->assertSame(null, $user->getUpdated());

        $this->userRepository->update($user);
        $this->assertTrue($user->getUpdated() instanceof DateTime);

        $this->userRepository->delete($user);
        $this->assertSame(null, $user->getId());
    }

    public function testCreateUserLogin()
    {
        $userLogin = $this->dummyData->getUserLogin();

        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $user->addUserLogin($userLogin);

        $this->userRepository->update($user);

        $this->assertSame(1, $user->getTotalLogins());
    }

    public function testFindOneById()
    {
        $this->setupUser();

        $this->setCountLogger();

        $user = $this->userRepository
            ->findOneById(1);

        $user->getOrders()->toArray();
        $user->getUserLogins()->toArray();
        $user->getUserTokens()->toArray();
        $user->getUserRoles()->toArray();

        $this->assertTrue($user instanceof User);
        $this->assertSame(5, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'User not found'
        );

        $this->userRepository->findOneById(1);
    }

    public function testGetAllUsers()
    {
        $this->setupUser();

        $users = $this->userRepository->getAllUsers('John');

        $this->assertTrue($users[0] instanceof User);
    }

    public function testGetAllUsersByIds()
    {
        $this->setupUser();

        $users = $this->userRepository->getAllUsersByIds([1]);

        $this->assertTrue($users[0] instanceof User);
    }

    public function testFindByEmailUsingEmail()
    {
        $this->setupUserWithCart();

        $this->setCountLogger();

        $user = $this->userRepository->findOneByEmail('test1@example.com');
        $user->getUserRoles()->toArray();
        $user->getCart()->getCreated();

        $this->assertTrue($user instanceof User);
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testFindOneByEmailThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'User not found'
        );

        $this->userRepository->findOneByEmail('test1@example.com');
    }
}
