<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityValidator;
use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\Entity\ValidationInterface;

trait EntityValidationTrait
{
    /**
     * @param ValidationInterface $entity
     * @throws EntityValidatorException
     */
    public function throwValidationErrors(ValidationInterface $entity)
    {
        $validator = new EntityValidator;
        $validator->throwValidationErrors($entity);
    }
}
