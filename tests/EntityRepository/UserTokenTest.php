<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class UserTokenTest extends Helper\DoctrineTestCase
{
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
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
