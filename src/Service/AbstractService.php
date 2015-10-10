<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityValidator;
use inklabs\kommerce\Entity\ValidationInterface;

abstract class AbstractService
{
    public function throwValidationErrors(ValidationInterface $entity)
    {
        $validator = new EntityValidator;
        $validator->throwValidationErrors($entity);
    }
}
