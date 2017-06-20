<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

interface ReferenceNumberGeneratorInterface
{
    public function generate(): string;
}
