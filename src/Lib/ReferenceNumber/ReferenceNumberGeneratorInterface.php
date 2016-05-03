<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

interface ReferenceNumberGeneratorInterface
{
    /**
     * @param ReferenceNumberEntityInterface $entity
     * @throws \RuntimeException
     */
    public function generate(ReferenceNumberEntityInterface & $entity);
}
