<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Exception\BadMethodCallException;
use inklabs\kommerce\tests\Helper;

class UserLoginRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User',
        'kommerce:UserLogin',
        'kommerce:UserToken',
        'kommerce:Cart',
        'kommerce:TaxRate',
    ];

    /** @var UserLoginRepositoryInterface */
    protected $userLoginRepository;

    public function setUp()
    {
        parent::setUp();
        $this->userLoginRepository = $this->getRepositoryFactory()->getUserLoginRepository();
    }

    private function setupUserLogin()
    {
        $user = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken();
        $userLogin = $this->dummyData->getUserLogin();
        $userLogin->setUser($user);
        $userLogin->setUserToken($userToken);

        $this->entityManager->persist($user);
        $this->entityManager->persist($userLogin);
        $this->entityManager->persist($userToken);
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

    public function testUpdateThrowsException()
    {
        $userLogin = $this->dummyData->getUserLogin();

        $this->setExpectedException(
            BadMethodCallException::class,
            'Update not allowed'
        );

        $this->userLoginRepository->update($userLogin);
    }

    public function testFind()
    {
        $this->setupUserLogin();

        $this->setCountLogger();
        $userLogin = $this->userLoginRepository->findOneById(1);

        $userLogin->getUser()->getCreated();
        $userLogin->getUserToken()->getCreated();

        $this->assertTrue($userLogin instanceof UserLogin);
        $this->assertTrue($userLogin->getUser() instanceof User);
        $this->assertTrue($userLogin->getUserToken() instanceof UserToken);
        $this->assertSame(2, $this->getTotalQueries());
    }
}
