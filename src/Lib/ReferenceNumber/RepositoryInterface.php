<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

interface RepositoryInterface
{
    /**
     * Is the Reference Number already in use?
     *
     * @param string $referenceNumber
     * @return bool
     */
    public function referenceNumberExists($referenceNumber);
}
