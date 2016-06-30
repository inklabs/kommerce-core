<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class UserTokenRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        User::class,
        UserToken::class,
        Cart::class,
        TaxRate::class,
    ];

    /** @var UserTokenRepositoryInterface */
    protected $userTokenRepository;

    public function setUp()
    {
        parent::setUp();
        $this->userTokenRepository = $this->getRepositoryFactory()->getUserTokenRepository();
    }

    public function setupUserWithToken()
    {
        $user = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken($user);

        $this->entityManager->persist($userToken);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $userToken;
    }

    public function testCRUD()
    {
        $user = $this->dummyData->getUser();
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->executeRepositoryCRUD(
            $this->userTokenRepository,
            $this->dummyData->getUserToken($user)
        );
    }

    public function testFind()
    {
        $originalUserToken = $this->setupUserWithToken();
        $this->setCountLogger();

        $userToken = $this->userTokenRepository->findOneById(
            $originalUserToken->getId()
        );

        $userToken->getUser()->getCreated();

        $this->assertEntitiesEqual($originalUserToken, $userToken);
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testFindLatestOneByUserId()
    {
        $originalUserToken = $this->setupUserWithToken();
        $this->setCountLogger();

        $userToken = $this->userTokenRepository->findLatestOneByUserId(
            $originalUserToken->getUser()->getId()
        );

        $userToken->getUser()->getEmail();

        $this->assertEntitiesEqual($originalUserToken, $userToken);
        $this->assertSame(2, $this->getTotalQueries());
    }
}
