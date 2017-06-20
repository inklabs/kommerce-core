<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;

interface ValidationInterface
{
    public static function loadValidatorMetadata(ClassMetadata $metadata): void;
}
