<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\KommerceException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class EntityValidatorException extends KommerceException
{
    /** @var ConstraintViolationListInterface */
    public $errors;
}
