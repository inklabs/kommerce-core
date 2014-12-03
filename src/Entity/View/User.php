<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class User
{
    public $id;
    public $email;
    public $username;
    public $firstName;
    public $lastName;
    public $totalLogins;
    public $lastLogin;
    public $status;

    /* @var Role[] */
    public $roles = [];

    /* @var Token[] */
    public $tokens = [];

    public function __construct(Entity\User $user)
    {
        $this->user = $user;

        $this->id          = $user->getId();
        $this->email       = $user->getEmail();
        $this->username    = $user->getUsername();
        $this->firstName   = $user->getFirstName();
        $this->lastName    = $user->getLastName();
        $this->totalLogins = $user->getTotalLogins();
        $this->lastLogin   = $user->getLastLogin();
        $this->status      = $user->getStatus();

        return $this;
    }

    public static function factory(Entity\User $user)
    {
        return new static($user);
    }

    public function export()
    {
        unset($this->user);
        return $this;
    }

    public function withRoles()
    {
//        foreach ($this->user->getRoles() as $role) {
//            $this->roles[] = Role::factory($role)
//                ->export();
//        }
        return $this;
    }

    public function withTokens()
    {
//        foreach ($this->user->getTokens() as $token) {
//            $this->tokens[] = Token::factory($token)
//                ->export();
//        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withRoles()
            ->withTokens();
    }
}
