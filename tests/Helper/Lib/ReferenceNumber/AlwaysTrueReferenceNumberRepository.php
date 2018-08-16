<?php
namespace inklabs\kommerce\tests\Helper\Lib\ReferenceNumber;

use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberRepositoryInterface;

class AlwaysTrueReferenceNumberRepository implements ReferenceNumberRepositoryInterface
{
    public function referenceNumberExists(string $referenceNumber): bool
    {
        return true;
    }
}
