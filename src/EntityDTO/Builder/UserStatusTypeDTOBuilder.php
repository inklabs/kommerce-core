<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\EntityDTO\UserStatusTypeDTO;

/**
 * @method UserStatusTypeDTO build()
 */
class UserStatusTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var UserStatusType */
    protected $entity;

    /** @var UserStatusTypeDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new UserStatusTypeDTO;
    }

    protected function preBuild()
    {
        $this->entityDTO->isInactive = $this->entity->isInactive();
        $this->entityDTO->isActive   = $this->entity->isActive();
        $this->entityDTO->isLocked   = $this->entity->isLocked();
    }
}
