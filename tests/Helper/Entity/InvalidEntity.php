<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use inklabs\kommerce\Entity\ValidationInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

final class InvalidEntity implements ValidationInterface
{
    protected $isValid = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('isValid', new Assert\NotNull);
    }

    public function setIsValid()
    {
        $this->isValid = true;
    }
}
