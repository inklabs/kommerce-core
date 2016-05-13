<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberEntityInterface;

class FakeReferenceNumberEntity implements ReferenceNumberEntityInterface
{
    /** @var int */
    public $id = 1;

    /** @var string */
    public $referenceNumber = '000-0000000-0000001';

    public function getReferenceId()
    {
        return $this->id;
    }

    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
    }
}
