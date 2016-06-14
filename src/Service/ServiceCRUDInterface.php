<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityInterface;

interface ServiceCRUDInterface
{
    public function create(EntityInterface & $entity);
    public function update(EntityInterface & $entity);
}
