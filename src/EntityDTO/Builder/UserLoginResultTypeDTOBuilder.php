<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserLoginResultType;
use inklabs\kommerce\EntityDTO\UserLoginResultTypeDTO;

/**
 * @method UserLoginResultTypeDTO build()
 */
class UserLoginResultTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var UserLoginResultType */
    protected $entity;

    /** @var UserLoginResultTypeDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new UserLoginResultTypeDTO;
    }

    protected function preBuild()
    {
        $this->entityDTO->isFail    = $this->entity->isFail();
        $this->entityDTO->isSuccess = $this->entity->isSuccess();
    }
}
