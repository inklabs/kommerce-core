<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

use inklabs\kommerce\Exception\RuntimeException;

interface ReferenceNumberGeneratorInterface
{
    /**
     * @return string
     * @throws RuntimeException
     */
    public function generate();
}
