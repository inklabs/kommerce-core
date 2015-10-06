<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityValidator;
use inklabs\kommerce\Entity\ValidationInterface;
use inklabs\kommerce\Lib;

abstract class AbstractService
{
    public function throwValidationErrors(ValidationInterface $entity)
    {
        $validator = new EntityValidator;
        $validator->throwValidationErrors($entity);
    }
}
