<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

use inklabs\kommerce\Exception\RuntimeException;

class HashSegmentGenerator implements GeneratorInterface
{
    /** @var int[]  */
    protected $segments = [3, 7, 7];

    /** @var int */
    protected $lookupLimit = 3;

    /** @var RepositoryInterface */
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function generate(ReferenceNumberEntityInterface & $entity)
    {
        do {
            $this->throwExceptionWhenBeyondLookupLimit();
            $referenceNumber = $this->generateHashSegments();
        } while ($this->repository->referenceNumberExists($referenceNumber));

        $entity->setReferenceNumber($referenceNumber);
    }

    protected function generateHashSegments()
    {
        $referenceNumberPieces = [];
        foreach ($this->segments as $length) {
            $referenceNumberPieces[] = $this->generateHashSegment($length);
        }
        $referenceNumber = implode('-', $referenceNumberPieces);

        return $referenceNumber;
    }

    protected function generateHashSegment($length)
    {
        $largeRandomNumber = str_pad(mt_rand(), $length, 0, STR_PAD_LEFT);
        return substr($largeRandomNumber, 0, $length);
    }

    /**
     * @param int[] $segments
     */
    public function setSegments(array $segments)
    {
        $this->segments = $segments;
    }

    private function throwExceptionWhenBeyondLookupLimit()
    {
        if ($this->lookupLimit < 1) {
            throw new RuntimeException('Lookup limit reached');
        }

        $this->lookupLimit--;
    }
}
