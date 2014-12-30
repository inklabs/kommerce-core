<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class UserToken
{
    public $id;
    public $userAgent;
    public $token;
    public $expires;
    public $type;
    public $typeText;
    public $created;
    public $updated;

    /* @var User */
    public $user;

    public function __construct(Entity\UserToken $userToken)
    {
        $this->userToken = $userToken;

        $this->id        = $userToken->getId();
        $this->userAgent = $userToken->getUserAgent();
        $this->token     = $userToken->getToken();
        $this->expires   = $userToken->getExpires();
        $this->type      = $userToken->getType();
        $this->type      = $userToken->getType();
        $this->created   = $userToken->getCreated();
        $this->updated   = $userToken->getUpdated();
    }

    public function export()
    {
        unset($this->userToken);
        return $this;
    }

    public function withUser()
    {
        $user = $this->userToken->getUser();
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
