<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class UserTest extends Helper\DoctrineTestCase
{
    /* @var Entity\User */
    protected $user;

    /**
     * @return User
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:User');
    }

    /**
     * @return Entity\User
     */
    private function getDummyUser($num)
    {
        $userRole = new Entity\UserRole;
        $userRole->setName('Administrator');
        $userRole->setDescription('Admin account. Access to everything');

        $userToken = new Entity\UserToken;
        $userToken->setUserAgent('SampleBot/1.1');
        $userToken->settoken('xxxx');
        $userToken->setexpires(new \DateTime);
        $userToken->setType(Entity\UserToken::TYPE_FACEBOOK);

        $userLogin1 = new Entity\UserLogin;
        $userLogin1->setUsername('johndoe');
        $userLogin1->setIp4('8.8.8.8');
        $userLogin1->setResult(Entity\UserLogin::RESULT_SUCCESS);

        $userLogin2 = clone $userLogin1;
        $userLogin3 = clone $userLogin1;
        $userLogin4 = clone $userLogin1;

        $user = new Entity\User;
        $user->setFirstName('John ' . $num);
        $user->setLastName('Doe');
        $user->setEmail('john@example.com');
        $user->setUsername('johndoe');
        $user->setPassword('xxx');
        $user->addRole($userRole);
        $user->addToken($userToken);
        $user->addLogin($userLogin1);
        $user->addLogin($userLogin2);
        $user->addLogin($userLogin3);
        $user->addLogin($userLogin4);
        return $user;
    }

    private function setupUser()
    {
        $user1 = $this->getDummyUser(1);

        $this->entityManager->persist($user1);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupUser();

        $user = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $user->getId());
    }

    public function testGetAllUsers()
    {
        $this->setupUser();

        $users = $this->getRepository()
            ->getAllUsers('John');

        $this->assertSame(1, $users[0]->getId());
    }

    public function testGetAllUsersByIds()
    {
        $this->setupUser();

        $users = $this->getRepository()
            ->getAllUsersByIds([1]);

        $this->assertSame(1, $users[0]->getId());
    }

    public function testFindByUsernameOrEmailUsingUsername()
    {
        $this->setupUser();

        $user = $this->getRepository()
            ->findOneByUsernameOrEmail('johndoe');

        $this->assertSame(1, $user->getId());
    }

    public function testFindByUsernameOrEmailUsingEmail()
    {
        $this->setupUser();

        $user = $this->getRepository()
            ->findOneByUsernameOrEmail('john@example.com');

        $this->assertSame(1, $user->getId());
    }
}
