<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserRoleType extends AbstractIntegerType
{
    const DEVELOPER = 0;
    const ADMIN     = 1;

    public static function getNameMap()
    {
        return [
            self::DEVELOPER => 'Developer',
            self::ADMIN => 'Admin',
        ];
    }

    public static function getSlugMap()
    {
        return [
            self::DEVELOPER => 'developer',
            self::ADMIN => 'admin',
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public static function developer()
    {
        return new self(self::DEVELOPER);
    }

    public static function admin()
    {
        return new self(self::ADMIN);
    }

    public function isDeveloper()
    {
        return $this->id === self::DEVELOPER;
    }

    public function isAdmin()
    {
        return $this->id === self::ADMIN;
    }
}
