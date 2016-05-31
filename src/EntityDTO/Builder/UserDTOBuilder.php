<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\UserDTO;

class UserDTOBuilder
{
    /** @var User */
    protected $user;

    /** @var UserDTO */
    protected $userDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(User $user, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->user = $user;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->userDTO = $this->getUserDTO();
        $this->userDTO->id          = $this->user->getId();
        $this->userDTO->externalId  = $this->user->getExternalId();
        $this->userDTO->email       = $this->user->getEmail();
        $this->userDTO->firstName   = $this->user->getFirstName();
        $this->userDTO->lastName    = $this->user->getLastName();
        $this->userDTO->totalLogins = $this->user->getTotalLogins();
        $this->userDTO->lastLogin   = $this->user->getLastLogin();
        $this->userDTO->created     = $this->user->getCreated();
        $this->userDTO->updated     = $this->user->getUpdated();

        $this->userDTO->status = $this->dtoBuilderFactory
            ->getUserStatusTypeDTOBuilder($this->user->getStatus())
            ->build();
    }

    protected function getUserDTO()
    {
        return new UserDTO;
    }

    public function withRoles()
    {
        foreach ($this->user->getUserRoles() as $role) {
            $this->userDTO->userRoles[] = $this->dtoBuilderFactory
                ->getUserRoleDTOBuilder($role)
                ->build();
        }
        return $this;
    }

    public function withTokens()
    {
        foreach ($this->user->getUserTokens() as $token) {
            $this->userDTO->userTokens[] = $this->dtoBuilderFactory
                ->getUserTokenDTOBuilder($token)
                ->build();
        }
        return $this;
    }

    public function withLogins()
    {
        foreach ($this->user->getUserLogins() as $login) {
            $this->userDTO->userLogins[] = $this->dtoBuilderFactory
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
        return $this->userDTO;
    }
}
