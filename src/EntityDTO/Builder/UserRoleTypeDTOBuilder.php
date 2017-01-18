<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserRoleType;
use inklabs\kommerce\EntityDTO\UserRoleTypeDTO;

/**
 * @method UserRoleTypeDTO build()
 */
class UserRoleTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var UserRoleType */
    protected $entity;

    /** @var UserRoleTypeDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new UserRoleTypeDTO();
    }

    protected function preBuild()
    {
        $this->entityDTO->isAdmin = $this->entity->isAdmin();
        $this->entityDTO->isDeveloper = $this->entity->isDeveloper();
    }
}
