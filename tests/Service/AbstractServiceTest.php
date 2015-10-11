<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper;

class AbstractServiceTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Tag',
    ];

    public function testThrowValidationErrors()
    {
        /** @var AbstractService|\Mockery\MockInterface $mockAbstractService */
        $mockAbstractService = \Mockery::mock(AbstractService::class)
            ->makePartial();

        $mockAbstractService
            ->shouldReceive('find')
            ->andReturn(new Product);

        $tag = new Tag;
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
        $mockAbstractService = \Mockery::mock(AbstractService::class)
            ->makePartial();

        $mockAbstractService
            ->shouldReceive('find')
            ->andReturn(new Product);

        $tag = new Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(-1);
        $tag->setIsVisible(true);
        $tag->setIsActive(true);

        $mockAbstractService->throwValidationErrors($tag);
    }
}
