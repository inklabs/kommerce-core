<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\UserDTO;

class UserDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var User */
    protected $entity;

    /** @var UserDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(User $user, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $user;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = $this->getEntityDTO();
        $this->setId();
        $this->setTime();
        $this->entityDTO->externalId  = $this->entity->getExternalId();
        $this->entityDTO->email       = $this->entity->getEmail();
        $this->entityDTO->firstName   = $this->entity->getFirstName();
        $this->entityDTO->lastName    = $this->entity->getLastName();
        $this->entityDTO->totalLogins = $this->entity->getTotalLogins();
        $this->entityDTO->lastLogin   = $this->entity->getLastLogin();

        $this->entityDTO->status = $this->dtoBuilderFactory
            ->getUserStatusTypeDTOBuilder($this->entity->getStatus())
            ->build();
    }

    protected function getEntityDTO()
    {
        return new UserDTO;
    }

    public function withRoles()
    {
        foreach ($this->entity->getUserRoles() as $role) {
            $this->entityDTO->userRoles[] = $this->dtoBuilderFactory
                ->getUserRoleDTOBuilder($role)
                ->build();
        }
        return $this;
    }

    public function withTokens()
    {
        foreach ($this->entity->getUserTokens() as $token) {
            $this->entityDTO->userTokens[] = $this->dtoBuilderFactory
                ->getUserTokenDTOBuilder($token)
                ->build();
        }
        return $this;
    }

    public function withLogins()
    {
        foreach ($this->entity->getUserLogins() as $login) {
            $this->entityDTO->userLogins[] = $this->dtoBuilderFactory
                ->getUserLoginDTOBuilder($login)
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withRoles()
            ->withTokens()
            ->withLogins();
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
