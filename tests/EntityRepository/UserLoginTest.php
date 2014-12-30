<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class UserLoginTest extends Helper\DoctrineTestCase
{
    /**
     * @return UserLogin
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:UserLogin');
    }

    public function setUp()
    {
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
        $user->addLogin($userLogin);

        $this->entityManager->persist($userLogin);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        /* @var Entity\UserLogin $userLogin */
        $userLogin = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $userLogin->getId());
    }
}
