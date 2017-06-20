<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\EntityValidatorException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class EntityValidator
{
    public function throwValidationErrors(ValidationInterface $entity)
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        /** @var ConstraintViolationList $errors */
        $errors = $validator->validate($entity);

        if (count($errors) > 0) {
            $message = '';
            foreach ($errors as $error) {
                $message .= $error->getPropertyPath() . ', '  . $error->getMessage() . PHP_EOL;
            }

            throw EntityValidatorException::withErrors($message, $errors);
        }
    }
}
