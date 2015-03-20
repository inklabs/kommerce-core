<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class UserTest extends Helper\DoctrineTestCase
{
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

    private function getDummyUser($num = 1)
    {
        $user = new Entity\User;
        $user->setFirstName('John ' . $num);
        $user->setLastName('Doe');
        $user->setEmail('john@example.com');
        $user->setUsername('johndoe');
        $user->setPassword('xxx');

        return $user;
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

    public function testFindByUsernameOrEmailUsingUsername()
    {
        $this->setupUser();

        $user = $this->getRepository()
            ->findOneByUsernameOrEmail('johndoe');

        $this->assertTrue($user instanceof Entity\User);
    }

    public function testFindByUsernameOrEmailUsingEmail()
    {
        $this->setupUser();

        $user = $this->getRepository()
            ->findOneByUsernameOrEmail('john@example.com');

        $this->assertTrue($user instanceof Entity\User);
    }
}
