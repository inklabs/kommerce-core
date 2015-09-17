<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class UserLoginRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:UserLogin',
        'kommerce:User',
        'kommerce:Cart',
        'kommerce:TaxRate',
    ];

    /** @var UserLoginRepositoryInterface */
    protected $userLoginRepository;

    public function setUp()
    {
        $this->userLoginRepository = $this->repository()->getUserLoginRepository();
    }

    private function setupUserLogin()
    {
        $user = $this->getDummyUser();
        $userLogin = $this->getDummyUserLogin();
        $userLogin->setUser($user);

        $this->entityManager->persist($user);
        $this->entityManager->persist($userLogin);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $userLogin;
    }

    public function testSave()
    {
        $userLogin = $this->setupUserLogin();

        $this->assertSame(1, $userLogin->getResult());
        $userLogin->setResult(2);

        $this->userLoginRepository->save($userLogin);
        $this->assertSame(2, $userLogin->getResult());
    }

    public function testCRUD()
    {
        $userLogin = $this->getDummyUserLogin();

        $this->userLoginRepository->create($userLogin);
        $this->assertSame(1, $userLogin->getId());

        $userLogin->setEmail('NewEmail@example.com');

        $this->userLoginRepository->save($userLogin);

        $this->userLoginRepository->remove($userLogin);
        $this->assertSame(null, $userLogin->getId());
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
}
