<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\QueryBuilder as KommerceQueryBuilder;
use inklabs\kommerce\tests\Helper;

class AbstractEntityRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User',
        'kommerce:Cart',
    ];

    /** @var UserRepositoryInterface */
    protected $userRepository;

    public function setUp()
    {
        $this->userRepository = $this->repository()->getUserRepository();
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
        $queryBuilder = $this->userRepository->getQueryBuilder();
        $this->assertTrue($queryBuilder instanceof KommerceQueryBuilder);
    }

    public function testSave()
    {
        $user = $this->getUser();

        $this->assertSame(null, $user->getUpdated());

        $user->setFirstName('NewName');

        $this->userRepository->save($user);

        $this->assertTrue($user->getUpdated() !== null);
    }

    public function testCreate()
    {
        $user = $this->getDummyUser();

        $this->assertSame(null, $user->getId());

        $this->userRepository->create($user);

        $this->assertSame(1, $user->getId());
        $this->assertSame(null, $user->getUpdated());
    }
}
