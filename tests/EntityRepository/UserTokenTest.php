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

    public function setUp()
    {
        $userToken = new Entity\UserToken;
        $userToken->setUserAgent('SampleBot/1.1');
        $userToken->settoken('xxxx');
        $userToken->setexpires(new \DateTime);
        $userToken->setType(Entity\UserToken::TYPE_FACEBOOK);

        $user = new Entity\User;
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('john@example.com');
        $user->setUsername('johndoe');
        $user->setPassword('xxx');
        $user->addToken($userToken);

        $this->entityManager->persist($userToken);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        /* @var Entity\UserToken $userToken */
        $userToken = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $userToken->getId());
    }
}
