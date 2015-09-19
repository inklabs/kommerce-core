<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\Lib\BaseConvert;

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
        $this->userDTO->encodedId   = BaseConvert::encode($this->user->getId());
        $this->userDTO->email       = $this->user->getEmail();
        $this->userDTO->firstName   = $this->user->getFirstName();
        $this->userDTO->lastName    = $this->user->getLastName();
        $this->userDTO->totalLogins = $this->user->getTotalLogins();
        $this->userDTO->lastLogin   = $this->user->getLastLogin();
        $this->userDTO->status      = $this->user->getStatus();
        $this->userDTO->statusText  = $this->user->getStatusText();
        $this->userDTO->created     = $this->user->getCreated();
        $this->userDTO->updated     = $this->user->getUpdated();
    }

    public function withRoles()
    {
        foreach ($this->user->getRoles() as $role) {
            $this->userDTO->roles[] = $role->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withTokens()
    {
        foreach ($this->user->getTokens() as $token) {
            $this->userDTO->tokens[] = $token->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withLogins()
    {
        foreach ($this->user->getLogins() as $login) {
            $this->userDTO->logins[] = $login->getDTOBuilder()
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
