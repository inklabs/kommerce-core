<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

use inklabs\kommerce\Exception\RuntimeException;

class HashSegmentReferenceNumberGenerator implements ReferenceNumberGeneratorInterface
{
    /** @var int[]  */
    protected $segments = [3, 7, 7];

    /** @var int */
    protected $lookupLimit = 3;

    /** @var ReferenceNumberRepositoryInterface */
    protected $repository;

    public function __construct(ReferenceNumberRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function generate()
    {
        do {
            $this->throwExceptionWhenBeyondLookupLimit();
            $referenceNumber = $this->generateHashSegments();
        } while ($this->repository->referenceNumberExists($referenceNumber));

        return $referenceNumber;
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
        $largeRandomNumber = random_int(pow(10, $length), pow(10, $length + 1));
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
