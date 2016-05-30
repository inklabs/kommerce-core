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

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->userDTO = new UserDTO;
        $this->userDTO->id          = $this->user->getId();
        $this->userDTO->externalId  = $this->user->getExternalId();
        $this->userDTO->email       = $this->user->getEmail();
        $this->userDTO->firstName   = $this->user->getFirstName();
        $this->userDTO->lastName    = $this->user->getLastName();
        $this->userDTO->totalLogins = $this->user->getTotalLogins();
        $this->userDTO->lastLogin   = $this->user->getLastLogin();
        $this->userDTO->created     = $this->user->getCreated();
        $this->userDTO->updated     = $this->user->getUpdated();

        $this->userDTO->status = $this->user->getStatus()->getDTOBuilder()
            ->build();
    }

    public function withRoles()
    {
        foreach ($this->user->getUserRoles() as $role) {
            $this->userDTO->userRoles[] = $role->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withTokens()
    {
        foreach ($this->user->getUserTokens() as $token) {
            $this->userDTO->userTokens[] = $token->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withLogins()
    {
        foreach ($this->user->getUserLogins() as $login) {
            $this->userDTO->userLogins[] = $login->getDTOBuilder()
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
        return $this->userDTO;
    }
}
