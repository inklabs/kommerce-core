<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;

interface ValidationInterface extends EntityInterface
{
    public static function loadValidatorMetadata(ClassMetadata $metadata);
}
