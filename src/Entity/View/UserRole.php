<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class UserRole
{
    public $id;
    public $name;
    public $description;

    /* @var User */
    public $user;

    public function __construct(Entity\UserRole $userRole)
    {
        $this->userRole = $userRole;

        $this->id          = $userRole->getId();
        $this->name        = $userRole->getName();
        $this->description = $userRole->getDescription();
    }

    public function export()
    {
        unset($this->userRole);
        return $this;
    }

    public function withUser()
    {
        $user = $this->userRole->getUser();
        if ($user !== null) {
            $this->user = $user->getView()
                ->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withUser();
    }
}
