<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

use inklabs\kommerce\Exception\RuntimeException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

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

        $referenceNumber = $this->hashSegmentGenerator->generate();

        $pieces = explode('-', $referenceNumber);
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

        $this->hashSegmentGenerator->setSegments([1, 2, 3, 4, 5]);
        $referenceNumber = $this->hashSegmentGenerator->generate();

        $pieces = explode('-', $referenceNumber);
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

        $this->setExpectedException(
            RuntimeException::class,
            'Lookup limit reached'
        );

        $this->hashSegmentGenerator->generate();
    }
}
