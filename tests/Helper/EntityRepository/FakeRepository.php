<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberRepositoryInterface;

class FakeReferenceNumberRepository implements ReferenceNumberRepositoryInterface
{
    /** @var bool */
    protected $referenceNumberReturnValue = false;

    /**
     * @param bool $returnValue
     */
    public function setReferenceNumberReturnValue($returnValue)
    {
        $this->referenceNumberReturnValue = (bool) $returnValue;
    }

    public function referenceNumberExists($referenceNumber)
    {
        return $this->referenceNumberReturnValue;
    }
}
