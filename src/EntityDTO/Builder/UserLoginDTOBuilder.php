<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\EntityDTO\UserLoginDTO;
use inklabs\kommerce\Lib\BaseConvert;

class UserLoginDTOBuilder
{
    /** @var UserLogin */
    protected $userLogin;

    /** @var UserLoginDTO */
    protected $userLoginDTO;

    public function __construct(UserLogin $userLogin)
    {
        $this->userLogin = $userLogin;

        $this->userLoginDTO = new UserLoginDTO;
        $this->userLoginDTO->id         = $this->userLogin->getId();
        $this->userLoginDTO->encodedId  = BaseConvert::encode($this->userLogin->getId());
        $this->userLoginDTO->email      = $userLogin->getEmail();
        $this->userLoginDTO->ip4        = $userLogin->getIp4();
        $this->userLoginDTO->created    = $this->userLogin->getCreated();

        $this->userLoginDTO->result = $userLogin->getResult()->getDTOBuilder()
            ->build();
    }

    public function withUser()
    {
        $user = $this->userLogin->getUser();
        if ($user !== null) {
            $this->userLoginDTO->user = $user->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withUserToken()
    {
        $userToken = $this->userLogin->getUserToken();
        if ($userToken !== null) {
            $this->userLoginDTO->userToken = $userToken->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withUser()
            ->withUserToken();
    }

    public function build()
    {
        return $this->userLoginDTO;
    }
}
