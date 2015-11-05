<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class EntityValidatorException extends ValidatorException
{
    /** @var ConstraintViolationListInterface */
    public $errors;
}
