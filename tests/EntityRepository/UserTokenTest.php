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
    ];

    /**
     * @return UserToken
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:UserToken');
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

    public function testFind()
    {
        $this->setupUserWithToken();

        $this->setCountLogger();

        $userToken = $this->getRepository()
            ->find(1);

        $userToken->getUser()->getEmail();

        $this->assertTrue($userToken instanceof Entity\UserToken);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }
}
