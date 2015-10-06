<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

class EntityValidator
{
    public function throwValidationErrors(ValidationInterface $entity)
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errors = $validator->validate($entity);

        if (count($errors) > 0) {
            $exception = new ValidatorException;
            $exception->errors = $errors;
            throw $exception;
        }
    }
}
