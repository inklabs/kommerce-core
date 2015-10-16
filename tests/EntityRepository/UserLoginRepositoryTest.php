<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserLogin;
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
        $this->userLoginRepository = $this->getRepositoryFactory()->getUserLoginRepository();
    }

    private function setupUserLogin()
    {
        $user = $this->dummyData->getUser();
        $userLogin = $this->dummyData->getUserLogin();
        $userLogin->setUser($user);

        $this->entityManager->persist($user);
        $this->entityManager->persist($userLogin);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $userLogin;
    }

    public function testCRUD()
    {
        $userLogin = $this->dummyData->getUserLogin();
        $this->userLoginRepository->create($userLogin);
        $this->assertSame(1, $userLogin->getId());

        $this->userLoginRepository->delete($userLogin);
        $this->assertSame(null, $userLogin->getId());
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Update not allowed
     */
    public function testUpdateThrowsException()
    {
        $userLogin = $this->dummyData->getUserLogin();
        $this->userLoginRepository->update($userLogin);
    }

    public function testFind()
    {
        $this->setupUserLogin();

        $this->setCountLogger();

        $userLogin = $this->userLoginRepository->findOneById(1);

        $userLogin->getUser()->getCreated();

        $this->assertTrue($userLogin instanceof UserLogin);
        $this->assertSame(2, $this->getTotalQueries());
    }
}
