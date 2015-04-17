<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class UserLogin
{
    public $id;
    public $email;
    public $ip4;
    public $result;
    public $resultText;
    public $created;

    /** @var User */
    public $user;

    public function __construct(Entity\UserLogin $userLogin)
    {
        $this->userLogin = $userLogin;

        $this->id         = $userLogin->getId();
        $this->email      = $userLogin->getEmail();
        $this->ip4        = $userLogin->getIp4();
        $this->result     = $userLogin->getResult();
        $this->resultText = $userLogin->getResultText();
        $this->created    = $userLogin->getCreated();
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
