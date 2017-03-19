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

        $pieces = explode('-', $entity->getReferenceNumber());
        $this->assertCount(3, $pieces);
        $this->assertSame(3, strlen($pieces[0]));
        $this->assertSame(7, strlen($pieces[1]));
        $this->assertSame(7, strlen($pieces[2]));
    }

    public function testGenerateWithCustomSegments()
    {
        $this->repository->shouldReceive('referenceNumberExists')
            ->andReturn(false)
            ->once();

        $entity = new FakeReferenceNumberEntity;
        $this->hashSegmentGenerator->setSegments([1, 2, 3, 4, 5]);
        $this->hashSegmentGenerator->generate($entity);

        $pieces = explode('-', $entity->getReferenceNumber());
        $this->assertCount(5, $pieces);
        $this->assertSame(1, strlen($pieces[0]));
        $this->assertSame(2, strlen($pieces[1]));
        $this->assertSame(3, strlen($pieces[2]));
        $this->assertSame(4, strlen($pieces[3]));
        $this->assertSame(5, strlen($pieces[4]));
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
