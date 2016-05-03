<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

interface ReferenceNumberEntityInterface
{
    /**
     * @return int
     */
    public function getReferenceId();

    /**
     * @return mixed|null
     */
    public function getReferenceNumber();

    /**
     * @param string $referenceNumber
     */
    public function setReferenceNumber($referenceNumber);
}
