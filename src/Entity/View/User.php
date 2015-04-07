<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class User
{
    public $id;
    public $encodedId;
    public $externalId;
    public $email;
    public $username;
    public $firstName;
    public $lastName;
    public $totalLogins;
    public $lastLogin;
    public $status;
    public $statusText;
    public $created;
    public $updated;

    /** @var UserRole[] */
    public $roles = [];

    /** @var UserToken[] */
    public $tokens = [];

    /** @var UserLogin[] */
    public $logins = [];

    public function __construct(Entity\User $user)
    {
        $this->user = $user;

        $this->id          = $user->getId();
        $this->encodedId   = Lib\BaseConvert::encode($user->getId());
        $this->externalId  = $user->getExternalId();
        $this->email       = $user->getEmail();
        $this->username    = $user->getUsername();
        $this->firstName   = $user->getFirstName();
        $this->lastName    = $user->getLastName();
        $this->totalLogins = $user->getTotalLogins();
        $this->lastLogin   = $user->getLastLogin();
        $this->status      = $user->getStatus();
        $this->statusText  = $user->getStatusText();
        $this->created     = $user->getCreated();
        $this->updated     = $user->getUpdated();
    }

    public function export()
    {
        unset($this->user);
        return $this;
    }

    public function withRoles()
    {
        foreach ($this->user->getRoles() as $role) {
            $this->roles[] = $role->getView();
        }
        return $this;
    }

    public function withTokens()
    {
        foreach ($this->user->getTokens() as $token) {
            $this->tokens[] = $token->getView()
                ->export();
        }
        return $this;
    }

    public function withLogins()
    {
        foreach ($this->user->getLogins() as $login) {
            $this->logins[] = $login->getView()
                ->export();
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
}
