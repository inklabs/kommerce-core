<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

use inklabs\kommerce\Exception\RuntimeException;
use inklabs\kommerce\tests\Helper\Entity\FakeReferenceNumberEntity;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeReferenceNumberRepository;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class HashSegmentReferenceNumberGeneratorTest extends EntityRepositoryTestCase
{
    /** @var HashSegmentReferenceNumberGenerator */
    protected $hashSegmentGenerator;

    /** @var ReferenceNumberRepositoryInterface|\Mockery\Mock */
    protected $repository;

    public function setUp()
    {
        parent::setUp();
        $this->seedRandomNumberGenerator();

        $this->repository = $this->mockRepository->getOrderRepository();
        $this->hashSegmentGenerator = new HashSegmentReferenceNumberGenerator($this->repository);
    }

    public function testGenerate()
    {
        $this->repository->shouldReceive('referenceNumberExists')
            ->andReturn(false)
            ->once();

        $entity = new FakeReferenceNumberEntity;
        $this->hashSegmentGenerator->generate($entity);

        $this->assertSame('963-1273124-1535857', $entity->getReferenceNumber());
    }

    public function testGenerateWithCustomSegments()
    {
        $this->repository->shouldReceive('referenceNumberExists')
            ->andReturn(false)
            ->once();

        $entity = new FakeReferenceNumberEntity;
        $this->hashSegmentGenerator->setSegments([1, 2, 3, 4, 5]);
        $this->hashSegmentGenerator->generate($entity);

        $this->assertSame('9-12-153-3247-12944', $entity->getReferenceNumber());
    }

    public function testGenerateThrowsException()
    {
        $this->repository->shouldReceive('referenceNumberExists')
            ->andReturn(true)
            ->times(3);

        $entity = new FakeReferenceNumberEntity;

        $this->setExpectedException(
            RuntimeException::class,
            'Lookup limit reached'
        );

        $this->hashSegmentGenerator->generate($entity);
    }
}
