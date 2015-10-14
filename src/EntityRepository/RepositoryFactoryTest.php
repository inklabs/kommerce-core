<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\tests\Helper;

class RepositoryFactoryTest extends Helper\DoctrineTestCase
{
    public function testGetRepositories()
    {
        $repositoryFactory = new RepositoryFactory($this->entityManager);
        $this->assertTrue($repositoryFactory->getAttributeRepository() instanceof AttributeRepository);
    }
}
