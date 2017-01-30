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
        $userLogin = $this->dummyData->getUserLogin($user);

        $this->executeRepositoryCRUD(
            $this->userRepository,
            $user
        );

        $this->assertSame(1, $user->getTotalLogins());
    }

    public function testCreateUserLogin()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $userLogin = $this->dummyData->getUserLogin($user);
        $this->userRepository->update($user);

        $this->assertSame(1, $user->getTotalLogins());
    }

    public function testFindOneById()
    {
        $originalUser = $this->setupUser();
        $this->setCountLogger();

        $user = $this->userRepository->findOneById(
            $originalUser->getId()
        );

        $this->visitElements($user->getOrders());
        $this->visitElements($user->getUserLogins());
        $this->visitElements($user->getUserTokens());
        $this->visitElements($user->getUserRoles());

        $this->assertEntitiesEqual($originalUser, $user);
        $this->assertSame(5, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'User not found'
        );

        $this->userRepository->findOneById(
            $this->dummyData->getId()
        );
    }

    public function testGetAllUsersByIds()
    {
        $originalUser = $this->setupUser();

        $users = $this->userRepository->getAllUsersByIds([
            $originalUser->getId()
        ]);

        $this->assertEntitiesEqual($originalUser, $users[0]);
    }

    public function testFindByEmailUsingEmail()
    {
        $originalUser = $this->setupUserWithCart();
        $this->setCountLogger();

        $user = $this->userRepository->findOneByEmail(
            $originalUser->getEmail()
        );

        $this->visitElements($user->getUserRoles());
//        $user->getCart()->getCreated();

        $this->assertEntitiesEqual($originalUser, $user);
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
