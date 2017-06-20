<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityValidator;
use inklabs\kommerce\Exception\EntityValidatorException;
use inklabs\kommerce\Entity\ValidationInterface;

trait EntityValidationTrait
{
    public function throwValidationErrors(ValidationInterface $entity): void
    {
        $validator = new EntityValidator;
        $validator->throwValidationErrors($entity);
    }
}
