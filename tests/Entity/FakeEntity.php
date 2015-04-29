<?php
namespace inklabs\kommerce\tests\Entity;

use inklabs\kommerce\Lib\ReferenceNumber;

class FakeEntity implements ReferenceNumber\EntityInterface
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
