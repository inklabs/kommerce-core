<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserStatusType extends AbstractIntegerType
{
    const INACTIVE = 0;
    const ACTIVE = 1;
    const LOCKED = 2;

    public static function getNameMap()
    {
        return [
            self::INACTIVE => 'Inactive',
            self::ACTIVE => 'Active',
            self::LOCKED => 'Locked',
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public static function inactive()
    {
        return new self(self::INACTIVE);
    }

    public static function active()
    {
        return new self(self::ACTIVE);
    }

    public static function locked()
    {
        return new self(self::LOCKED);
    }

    public function isInactive()
    {
        return $this->id === self::INACTIVE;
    }

    public function isActive()
    {
        return $this->id === self::ACTIVE;
    }

    public function isLocked()
    {
        return $this->id === self::LOCKED;
    }
}
