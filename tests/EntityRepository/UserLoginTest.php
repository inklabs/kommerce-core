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

    /** @var UserLoginInterface */
    protected $userLoginRepository;

    public function setUp()
    {
        $this->userLoginRepository = $this->entityManager->getRepository('kommerce:UserLogin');
    }

    private function setupUserLogin()
    {
        $userLogin = $this->getDummyUserLogin();

        $user = $this->getDummyUser();
        $user->addLogin($userLogin);

        $this->entityManager->persist($user);

        $this->userLoginRepository->create($userLogin);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $userLogin;
    }

    public function testFind()
    {
        $this->setupUserLogin();

        $this->setCountLogger();

        $userLogin = $this->userLoginRepository->find(1);

        $userLogin->getUser()->getEmail();

        $this->assertTrue($userLogin instanceof Entity\UserLogin);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }
}
