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
        $userToken = $this->dummyData->getUserToken();

        $user = $this->dummyData->getUser();
        $user->addUserToken($userToken);

        $this->entityManager->persist($userToken);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testCRUD()
    {
        $userToken = $this->dummyData->getUserToken();

        $this->userTokenRepository->create($userToken);
        $this->assertSame(1, $userToken->getId());

        $userToken->setToken('New Token');
        $this->assertSame(null, $userToken->getUpdated());

        $this->userTokenRepository->update($userToken);
        $this->assertTrue($userToken->getUpdated() instanceof DateTime);

        $this->userTokenRepository->delete($userToken);
        $this->assertSame(null, $userToken->getId());
    }

    public function testFind()
    {
        $this->setupUserWithToken();

        $this->setCountLogger();

        $userToken = $this->userTokenRepository->findOneById(1);

        $userToken->getUser()->getEmail();

        $this->assertTrue($userToken instanceof UserToken);
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testFindLatestOneByUserId()
    {
        $this->setupUserWithToken();

        $this->setCountLogger();

        $userToken = $this->userTokenRepository->findLatestOneByUserId(1);

        $userToken->getUser()->getEmail();

        $this->assertTrue($userToken instanceof UserToken);
        $this->assertSame(2, $this->getTotalQueries());
    }
}
