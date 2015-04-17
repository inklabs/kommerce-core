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

    /**
     * @return User
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:User');
    }

    private function setupUser()
    {
        $user = $this->getDummyUser();

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupUser();

        $this->setCountLogger();

        $user = $this->getRepository()
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

        $users = $this->getRepository()
            ->getAllUsers('John');

        $this->assertTrue($users[0] instanceof Entity\User);
    }

    public function testGetAllUsersByIds()
    {
        $this->setupUser();

        $users = $this->getRepository()
            ->getAllUsersByIds([1]);

        $this->assertTrue($users[0] instanceof Entity\User);
    }

    public function testFindByEmailUsingEmail()
    {
        $this->setupUser();

        $user = $this->getRepository()
            ->findOneByEmail('test@example.com');

        $this->assertTrue($user instanceof Entity\User);
    }
}
