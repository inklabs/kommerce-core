<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class UserTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User',
        'kommerce:UserLogin',
        'kommerce:UserToken',
        'kommerce:UserRole',
        'kommerce:Order',
    ];

    /** @var User */
    protected $repository;

    public function setUp()
    {
        $this->repository = $this->entityManager->getRepository('kommerce:User');
    }

    private function setupUser()
    {
        $user = $this->getDummyUser();

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $user;
    }

    public function testFind()
    {
        $this->setupUser();

        $this->setCountLogger();

        $user = $this->repository
            ->find(1);

        $user->getOrders()->toArray();
        $user->getLogins()->toArray();
        $user->getTokens()->toArray();
        $user->getRoles()->toArray();

        $this->assertTrue($user instanceof Entity\User);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllUsers()
    {
        $this->setupUser();

        $users = $this->repository->getAllUsers('John');

        $this->assertTrue($users[0] instanceof Entity\User);
    }

    public function testGetAllUsersByIds()
    {
        $this->setupUser();

        $users = $this->repository->getAllUsersByIds([1]);

        $this->assertTrue($users[0] instanceof Entity\User);
    }

    public function testFindByEmailUsingEmail()
    {
        $this->setupUser();

        $user = $this->repository->findOneByEmail('test@example.com');

        $this->assertTrue($user instanceof Entity\User);
    }

    public function testCreateUserLogin()
    {
        $userLogin = $this->getDummyUserLogin();

        $user = $this->setupUser();
        $user->addLogin($userLogin);

        $this->repository->save($user);

        $this->assertSame(1, $user->getTotalLogins());
    }
}
