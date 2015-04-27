<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class AbstractServiceTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Tag',
    ];

    public function testFindByEncodedId()
    {
        /** @var AbstractService|\Mockery\MockInterface $mockAbstractService */
        $mockAbstractService = \Mockery::mock('inklabs\kommerce\Service\AbstractService')
            ->makePartial();

        $mockAbstractService
            ->shouldReceive('find')
            ->andReturn(new Entity\Product);

        $product = $mockAbstractService->findByEncodedId(1);
        $this->assertTrue($product instanceof Entity\Product);
    }

    public function testThrowValidationErrors()
    {
        /** @var AbstractService|\Mockery\MockInterface $mockAbstractService */
        $mockAbstractService = \Mockery::mock('inklabs\kommerce\Service\AbstractService')
            ->makePartial();

        $mockAbstractService
            ->shouldReceive('find')
            ->andReturn(new Entity\Product);

        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);
        $tag->setIsActive(true);

        $mockAbstractService->throwValidationErrors($tag);
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\ValidatorException
     */
    public function testThrowValidationErrorsThrowsError()
    {
        /** @var AbstractService|\Mockery\MockInterface $mockAbstractService */
        $mockAbstractService = \Mockery::mock('inklabs\kommerce\Service\AbstractService')
            ->makePartial();

        $mockAbstractService
            ->shouldReceive('find')
            ->andReturn(new Entity\Product);

        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(-1);
        $tag->setIsVisible(true);
        $tag->setIsActive(true);

        $mockAbstractService->throwValidationErrors($tag);
    }
}
