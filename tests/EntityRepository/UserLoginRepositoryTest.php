<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Exception\BadMethodCallException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class UserLoginRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        User::class,
        UserLogin::class,
        UserToken::class,
        Cart::class,
        TaxRate::class,
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
        $userToken = $this->dummyData->getUserToken($user);
        $userLogin = $this->dummyData->getUserLogin($user, $userToken);

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
        $this->userLoginRepository->delete($userLogin);
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
        $originalUserLogin = $this->setupUserLogin();
        $this->setCountLogger();

        $userLogin = $this->userLoginRepository->findOneById(
            $originalUserLogin->getId()
        );

        $userLogin->getUser()->getCreated();
        $userLogin->getUserToken()->getCreated();

        $this->assertEntitiesEqual($originalUserLogin, $userLogin);
        $this->assertEntitiesEqual($originalUserLogin->getUser(), $userLogin->getUser());
        $this->assertEntitiesEqual($originalUserLogin->getUserToken(), $userLogin->getUserToken());
        $this->assertSame(2, $this->getTotalQueries());
    }
}
