<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

use inklabs\kommerce\Exception\RuntimeException;
use inklabs\kommerce\tests\Helper\Entity\FakeReferenceNumberEntity;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeReferenceNumberRepository;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class HashSegmentReferenceNumberGeneratorTest extends EntityTestCase
{
    /** @var HashSegmentReferenceNumberGenerator */
    protected $hashSegmentGenerator;

    /** @var FakeReferenceNumberRepository */
    protected $repository;

    public function setUp()
    {
        mt_srand(0);

        $this->repository = new FakeReferenceNumberRepository;
        $this->hashSegmentGenerator = new HashSegmentReferenceNumberGenerator($this->repository);
    }

    public function testGenerate()
    {
        $entity = new FakeReferenceNumberEntity;
        $this->hashSegmentGenerator->generate($entity);

        $this->assertSame('963-1273124-1535857', $entity->getReferenceNumber());
    }

    public function testGenerateWithCustomSegments()
    {
        $entity = new FakeReferenceNumberEntity;
        $this->hashSegmentGenerator->setSegments([1, 2, 3, 4, 5]);
        $this->hashSegmentGenerator->generate($entity);

        $this->assertSame('9-12-153-3247-12944', $entity->getReferenceNumber());
    }

    public function testGenerateThrowsException()
    {
        $entity = new FakeReferenceNumberEntity;
        $this->repository->setReferenceNumberReturnValue(true);

        $this->setExpectedException(
            RuntimeException::class,
            'Lookup limit reached'
        );

        $this->hashSegmentGenerator->generate($entity);
    }
}
