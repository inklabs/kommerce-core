<?php
namespace inklabs\kommerce\tests\Helper;

use inklabs\kommerce\Lib\ReferenceNumber\RepositoryInterface;

class FakeRepository implements RepositoryInterface
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
