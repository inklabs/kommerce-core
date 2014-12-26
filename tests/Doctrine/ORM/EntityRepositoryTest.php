<?php
namespace inklabs\kommerce\Doctrine\ORM;

use inklabs\kommerce\tests\Helper as Helper;

class EntityRepositoryTest extends Helper\DoctrineTestCase
{
    public function testGetQueryBuilder()
    {
        $mockEntityRepository = \Mockery::mock('inklabs\kommerce\Doctrine\ORM\EntityRepository')
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockEntityRepository
            ->shouldReceive('getEntityManager')
            ->andReturn($this->entityManager);

        $queryBuilder = $mockEntityRepository->getQueryBuilder();
        $this->assertTrue($queryBuilder instanceof QueryBuilder);
    }
}
