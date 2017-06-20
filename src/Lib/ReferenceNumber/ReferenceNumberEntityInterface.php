<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

interface ReferenceNumberEntityInterface
{
    public function getReferenceNumber(): ?string;
    public function setReferenceNumber(string $referenceNumber);
}
