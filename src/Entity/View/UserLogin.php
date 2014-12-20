<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class UserLogin
{
    public $id;
    public $username;
    public $ip4;
    public $result;

    /* @var User */
    public $user;

    public function __construct(Entity\UserLogin $userLogin)
    {
        $this->userLogin = $userLogin;

        $this->id       = $userLogin->getId();
        $this->username = $userLogin->getUsername();
        $this->ip4      = $userLogin->getIp4();
        $this->result   = $userLogin->getResult();
    }

    public function export()
    {
        unset($this->userLogin);
        return $this;
    }

    public function withUser()
    {
        $user = $this->userLogin->getUser();
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
