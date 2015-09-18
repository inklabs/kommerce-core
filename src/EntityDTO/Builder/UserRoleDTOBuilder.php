<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\EntityDTO\UserRoleDTO;

class UserRoleDTOBuilder extends AbstractDTOBuilder
{
    /** @var UserRole */
    protected $entity;

    /** @var UserRoleDTO */
    protected $entityDTO;

    public function __construct(UserRole $userRole)
    {
        $this->entity = $userRole;

        $this->entityDTO = new UserRoleDTO;
        $this->entityDTO->name        = $this->entity->getName();
        $this->entityDTO->description = $this->entity->getDescription();

        $this->setId();
        $this->setTimestamps();
    }
}
