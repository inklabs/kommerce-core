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

    public function setUp()
    {
        $userRole = new Entity\UserRole;
        $userRole->setName('Administrator');
        $userRole->setDescription('Admin account. Access to everything');

        $userToken = new Entity\UserToken;
        $userToken->setUserAgent('SampleBot/1.1');
        $userToken->settoken('xxxx');
        $userToken->setexpires(new \DateTime);
        $userToken->setType(Entity\UserToken::TYPE_FACEBOOK);

        $userLogin = new Entity\UserLogin;
        $userLogin->setUsername('johndoe');
        $userLogin->setIp4('8.8.8.8');
        $userLogin->setResult(Entity\UserLogin::RESULT_SUCCESS);

        $user = new Entity\User;
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('john@example.com');
        $user->setUsername('johndoe');
        $user->setPassword('xxx');
        $user->addRole($userRole);
        $user->addToken($userToken);
        $user->addLogin($userLogin);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        /* @var Entity\User $user */
        $user = $this->getRepository()
            ->find(1);

        $this->assertEquals(1, $user->getId());
        $this->assertEquals(1, $user->getRoles()[0]->getId());
        $this->assertEquals(1, $user->getTokens()[0]->getId());
        $this->assertEquals(1, $user->getLogins()[0]->getId());
    }
}
