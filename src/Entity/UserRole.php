<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserRole implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var UserRoleType */
    protected $userRoleType;

    public function __construct(UserRoleType $userRoleType)
    {
        $this->setId();
        $this->setCreated();
        $this->userRoleType = $userRoleType;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('userRoleType', new Assert\Valid);
    }

    public function getUserRoleType(): UserRoleType
    {
        return $this->userRoleType;
    }
}
