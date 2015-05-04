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
        $this->userLoginRepository = $this->repository()->getUserLogin();
    }

    private function setupUserLogin()
    {
        $user = $this->getDummyUser();
        $userLogin = $this->getDummyUserLogin();
        $userLogin->setUser($user);

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

        $userLogin->getUser()->getCreated();

        $this->assertTrue($userLogin instanceof Entity\UserLogin);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }

    public function testSave()
    {
        $userLogin = $this->setupUserLogin();

        $this->assertSame(1, $userLogin->getResult());
        $userLogin->setResult(2);

        $this->userLoginRepository->save($userLogin);
        $this->assertSame(2, $userLogin->getResult());
    }
}
