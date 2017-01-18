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

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(UserRole $userRole, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $userRole;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new UserRoleDTO;
        $this->setId();
        $this->setTime();

        $this->entityDTO->userRoleType = $this->dtoBuilderFactory
            ->getUserRoleTypeDTOBuilder($this->entity->getUserRoleType())
            ->build();
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
