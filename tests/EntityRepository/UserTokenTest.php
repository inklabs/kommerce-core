<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class UserTokenTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User',
        'kommerce:UserToken',
        'kommerce:Cart',
        'kommerce:TaxRate',
    ];

    /** @var UserTokenInterface */
    protected $userTokenRepository;

    public function setUp()
    {
        $this->userTokenRepository = $this->repository()->getUserToken();
    }

    public function setupUserWithToken()
    {
        $userToken = $this->getDummyUserToken();

        $user = $this->getDummyUser();
        $user->addToken($userToken);

        $this->entityManager->persist($userToken);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testCRUD()
    {
        $userToken = $this->getDummyUserToken();

        $this->userTokenRepository->create($userToken);
        $this->assertSame(1, $userToken->getId());

        $userToken->setToken('New Token');
        $this->assertSame(null, $userToken->getUpdated());

        $this->userTokenRepository->save($userToken);
        $this->assertTrue($userToken->getUpdated() instanceof \DateTime);

        $this->userTokenRepository->remove($userToken);
        $this->assertSame(null, $userToken->getId());
    }

    public function testFind()
    {
        $this->setupUserWithToken();

        $this->setCountLogger();

        $userToken = $this->userTokenRepository->find(1);

        $userToken->getUser()->getEmail();

        $this->assertTrue($userToken instanceof Entity\UserToken);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }
}
