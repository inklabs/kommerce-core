<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\tests\Helper;

class FactoryRepositoryTest extends Helper\DoctrineTestCase
{
    public function testGetInstance()
    {
        $this->setupEntityManager();
        $factoryRepository = FactoryRepository::getInstance($this->entityManager);
        $this->assertTrue($factoryRepository instanceof FactoryRepository);
    }
}
