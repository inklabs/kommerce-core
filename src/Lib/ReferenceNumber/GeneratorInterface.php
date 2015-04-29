<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

interface GeneratorInterface
{
    /**
     * @param EntityInterface $entity
     * @throws \RuntimeException
     */
    public function generate(EntityInterface & $entity);
}
