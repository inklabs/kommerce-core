<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

interface ReferenceNumberRepositoryInterface
{
    public function referenceNumberExists(string $referenceNumber): bool;
}
