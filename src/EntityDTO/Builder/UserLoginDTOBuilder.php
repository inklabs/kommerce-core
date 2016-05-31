<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\EntityDTO\UserLoginDTO;

class UserLoginDTOBuilder
{
    /** @var UserLogin */
    protected $userLogin;

    /** @var UserLoginDTO */
    protected $userLoginDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(UserLogin $userLogin, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->userLogin = $userLogin;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->userLoginDTO = new UserLoginDTO;
        $this->userLoginDTO->id      = $this->userLogin->getId();
        $this->userLoginDTO->email   = $userLogin->getEmail();
        $this->userLoginDTO->ip4     = $userLogin->getIp4();
        $this->userLoginDTO->created = $this->userLogin->getCreated();

        $this->userLoginDTO->result = $this->dtoBuilderFactory
            ->getUserLoginResultTypeDTOBuilder($userLogin->getResult())
            ->build();
    }

    public function withUser()
    {
        $user = $this->userLogin->getUser();
        if ($user !== null) {
            $this->userLoginDTO->user = $this->dtoBuilderFactory
                ->getUserDTOBuilder($user)
                ->build();
        }
        return $this;
    }

    public function withUserToken()
    {
        $userToken = $this->userLogin->getUserToken();
        if ($userToken !== null) {
            $this->userLoginDTO->userToken = $this->dtoBuilderFactory
                ->getUserTokenDTOBuilder($userToken)
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
