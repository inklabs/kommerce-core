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

    private function setupUserWithLogin()
    {
        $userLogin = $this->getDummyUserLogin();

        $user = $this->getDummyUser();
        $user->addLogin($userLogin);

        $this->entityManager->persist($userLogin);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    private function getDummyUserLogin()
    {
        $userLogin = new Entity\UserLogin;
        $userLogin->setUsername('johndoe');
        $userLogin->setIp4('8.8.8.8');
        $userLogin->setResult(Entity\UserLogin::RESULT_SUCCESS);
        return $userLogin;
    }

    private function getDummyUser()
    {
        $user = new Entity\User;
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('john@example.com');
        $user->setUsername('johndoe');
        $user->setPassword('xxx');
        return $user;
    }

    public function testFind()
    {
        $this->setupUserWithLogin();

        $this->setCountLogger();

        $userLogin = $this->getRepository()
            ->find(1);

        $userLogin->getUser()->getEmail();

        $this->assertTrue($userLogin instanceof Entity\UserLogin);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
