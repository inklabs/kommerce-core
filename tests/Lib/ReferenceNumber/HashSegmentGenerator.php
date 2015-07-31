<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

use inklabs\kommerce\tests\Entity\FakeEntity;
use inklabs\kommerce\tests\Helper\FakeRepository;

class HashSegmentGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var HashSegmentGenerator */
    protected $hashSegmentGenerator;

    /** @var FakeRepository */
    protected $repository;

    public function setUp()
    {
        mt_srand(0);

        $this->repository = new FakeRepository;
        $this->hashSegmentGenerator = new HashSegmentGenerator($this->repository);
    }

    public function testGenerate()
    {
        $entity = new FakeEntity;
        $this->hashSegmentGenerator->generate($entity);

        $this->assertSame('963-1273124-1535857', $entity->getReferenceNumber());
    }

    public function testGenerateWithCustomSegments()
    {
        $entity = new FakeEntity;
        $this->hashSegmentGenerator->setSegments([1, 2, 3, 4, 5]);
        $this->hashSegmentGenerator->generate($entity);

        $this->assertSame('9-12-153-3247-12944', $entity->getReferenceNumber());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Lookup limit reached
     */
    public function testGenerateThrowsException()
    {
        $entity = new FakeEntity;
        $this->repository->setReferenceNumberReturnValue(true);
        $this->hashSegmentGenerator->generate($entity);
    }
}
