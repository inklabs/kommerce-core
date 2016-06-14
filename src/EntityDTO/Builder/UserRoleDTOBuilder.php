<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\EntityDTO\UserRoleDTO;

class UserRoleDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var UserRole */
    protected $entity;

    /** @var UserRoleDTO */
    protected $entityDTO;

    public function __construct(UserRole $userRole)
    {
        $this->entity = $userRole;

        $this->entityDTO = new UserRoleDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->name        = $this->entity->getName();
        $this->entityDTO->description = $this->entity->getDescription();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
