<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\EntityRepository\RepositoryFactory;
use inklabs\kommerce\tests\Helper;

class RepositoryFactoryTest extends Helper\DoctrineTestCase
{
    public function testGetInstance()
    {
        $this->setupEntityManager();
        $repositoryFactory = RepositoryFactory::getInstance($this->entityManager);
        $this->assertTrue($repositoryFactory instanceof RepositoryFactory);
    }
}
