<?php
namespace inklabs\kommerce\tests\Helper\Lib\ReferenceNumber;

use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberRepositoryInterface;

class AlwaysFalseReferenceNumberRepository implements ReferenceNumberRepositoryInterface
{
    public function referenceNumberExists(string $referenceNumber): bool
    {
        return false;
    }
}
