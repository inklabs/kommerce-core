<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\UserDTO;

class UserDTOBuilder extends AbstractDTOBuilder
{
    /** @var User */
    protected $entity;

    /** @var UserDTO */
    protected $entityDTO;

    public function __construct(User $user)
    {
        $this->entity = $user;

        $this->entityDTO = new UserDTO;
        $this->entityDTO->email       = $this->entity->getEmail();
        $this->entityDTO->firstName   = $this->entity->getFirstName();
        $this->entityDTO->lastName    = $this->entity->getLastName();
        $this->entityDTO->totalLogins = $this->entity->getTotalLogins();
        $this->entityDTO->lastLogin   = $this->entity->getLastLogin();
        $this->entityDTO->status      = $this->entity->getStatus();
        $this->entityDTO->statusText  = $this->entity->getStatusText();

        $this->setId();
        $this->setTimestamps();
    }

    public function withRoles()
    {
        foreach ($this->entity->getRoles() as $role) {
            $this->entityDTO->roles[] = $role->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withTokens()
    {
        foreach ($this->entity->getTokens() as $token) {
            $this->entityDTO->tokens[] = $token->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withLogins()
    {
        foreach ($this->entity->getLogins() as $login) {
            $this->entityDTO->logins[] = $login->getDTOBuilder()
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

    public function build()
    {
        return $this->entityDTO;
    }
}
