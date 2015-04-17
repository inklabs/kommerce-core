<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\tests\Helper;

class AbstractEntityRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User'
    ];

    /**
     * @return User
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:User');
    }

    private function getUser()
    {
        $user = $this->getDummyUser();

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $user;
    }

    public function testGetQueryBuilder()
    {
        $queryBuilder = $this->getRepository()->getQueryBuilder();
        $this->assertTrue($queryBuilder instanceof \inklabs\kommerce\Doctrine\ORM\QueryBuilder);
    }

    public function testSave()
    {
        $user = $this->getUser();

        $this->assertSame(null, $user->getUpdated());

        $user->setFirstName('NewName');

        $repository = $this->getRepository();
        $repository->save($user);

        $this->assertTrue($user->getUpdated() !== null);
    }
}
