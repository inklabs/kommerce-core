<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class UserLoginTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:UserLogin',
        'kommerce:User',
        'kommerce:Cart',
    ];

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

    public function testFind()
    {
        $this->setupUserWithLogin();

        $this->setCountLogger();

        $userLogin = $this->getRepository()
            ->find(1);

        $userLogin->getUser()->getEmail();

        $this->assertTrue($userLogin instanceof Entity\UserLogin);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }
}
