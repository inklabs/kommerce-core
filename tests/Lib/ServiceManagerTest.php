<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Service as Service;

class ServiceManagerTest extends Helper\DoctrineTestCase
{
    public function testSetEntityManager()
    {
        $serviceManager = new ServiceManager;
        $serviceManager->setEntityManager($this->entityManager);
    }

    public function testFindByEncodedId()
    {
        $mockServiceManager = \Mockery::mock('inklabs\kommerce\Lib\ServiceManager')
            ->makePartial();

        $mockServiceManager
            ->shouldReceive('find')
            ->andReturn(new Entity\Product);

        $product = $mockServiceManager->findByEncodedId(1);
        $this->assertTrue($product instanceof Entity\Product);
    }

    public function testThrowValidationErrors()
    {
        $mockServiceManager = \Mockery::mock('inklabs\kommerce\Lib\ServiceManager')
            ->makePartial();

        $mockServiceManager
            ->shouldReceive('find')
            ->andReturn(new Entity\Product);

        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);
        $tag->setIsActive(true);

        $mockServiceManager->throwValidationErrors($tag);
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\ValidatorException
     */
    public function testThrowValidationErrorsThrowsError()
    {
        $mockServiceManager = \Mockery::mock('inklabs\kommerce\Lib\ServiceManager')
            ->makePartial();

        $mockServiceManager
            ->shouldReceive('find')
            ->andReturn(new Entity\Product);

        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(-1);
        $tag->setIsVisible(true);
        $tag->setIsActive(true);

        $mockServiceManager->throwValidationErrors($tag);
    }
}
