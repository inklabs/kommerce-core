<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

interface ReferenceNumberRepositoryInterface
{
    /**
     * Is the Reference Number already in use?
     *
     * @param string $referenceNumber
     * @return bool
     */
    public function referenceNumberExists($referenceNumber);
}
