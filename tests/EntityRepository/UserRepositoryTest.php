<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper;

class UserRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User',
        'kommerce:UserLogin',
        'kommerce:UserToken',
        'kommerce:UserRole',
        'kommerce:Order',
        'kommerce:Cart',
        'kommerce:TaxRate',
    ];

    /** @var UserRepositoryInterface */
    protected $userRepository;

    public function setUp()
    {
        $this->userRepository = $this->repository()->getUserRepository();
    }

    private function setupUser()
    {
        $user = $this->getDummyUser();

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $user;
    }

    private function setupUserWithCart()
    {
        $user = $this->getDummyUser();

        $cart = $this->getDummyCart();
        $cart->setUser($user);

        $this->entityManager->persist($user);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $user;
    }

    public function testCRUD()
    {
        $user = $this->getDummyUser();

        $this->userRepository->create($user);
        $this->assertSame(1, $user->getId());

        $user->setFirstName('New First Name');
        $this->assertSame(null, $user->getUpdated());

        $this->userRepository->save($user);
        $this->assertTrue($user->getUpdated() instanceof \DateTime);

        $this->userRepository->remove($user);
        $this->assertSame(null, $user->getId());
    }

    public function testCreateUserLogin()
    {
        $userLogin = $this->getDummyUserLogin();

        $user = $this->setupUser();
        $user->addLogin($userLogin);

        $this->userRepository->save($user);

        $this->assertSame(1, $user->getTotalLogins());
    }

    public function testFind()
    {
        $this->setupUser();

        $this->setCountLogger();

        $user = $this->userRepository
            ->findOneById(1);

        $user->getOrders()->toArray();
        $user->getLogins()->toArray();
        $user->getTokens()->toArray();
        $user->getRoles()->toArray();

        $this->assertTrue($user instanceof User);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
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
        $user->getRoles()->toArray();
        $user->getCart()->getCreated();

        $this->assertTrue($user instanceof User);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }
}
