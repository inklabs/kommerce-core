<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

interface GeneratorInterface
{
    /**
     * @param ReferenceNumberEntityInterface $entity
     * @throws \RuntimeException
     */
    public function generate(ReferenceNumberEntityInterface & $entity);
}
