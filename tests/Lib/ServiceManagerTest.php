<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Service as Service;

class ServiceManagerTest extends Helper\DoctrineTestCase
{
    public function testSetEntityManager()
    {
        $emClass = new ServiceManager;
        $emClass->setEntityManager($this->entityManager);
    }

    public function testFindByEncodedId()
    {
        $mockEntityManager = \Mockery::mock('inklabs\kommerce\Lib\ServiceManager')
            ->makePartial();

        $mockEntityManager
            ->shouldReceive('find')
            ->andReturn(new Entity\Product);

        $product = $mockEntityManager->findByEncodedId(1);
        $this->assertTrue($product instanceof Entity\Product);
    }
}
