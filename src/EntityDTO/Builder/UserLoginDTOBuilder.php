<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\EntityDTO\UserLoginDTO;

class UserLoginDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait;

    /** @var UserLogin */
    protected $entity;

    /** @var UserLoginDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(UserLogin $userLogin, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $userLogin;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new UserLoginDTO;
        $this->setId();
        $this->entityDTO->created = $this->entity->getCreated();
        $this->entityDTO->email   = $userLogin->getEmail();
        $this->entityDTO->ip4     = $userLogin->getIp4();

        $this->entityDTO->result = $this->dtoBuilderFactory
            ->getUserLoginResultTypeDTOBuilder($userLogin->getResult())
            ->build();
    }

    public function withUser()
    {
        $user = $this->entity->getUser();
        if ($user !== null) {
            $this->entityDTO->user = $this->dtoBuilderFactory
                ->getUserDTOBuilder($user)
                ->build();
        }
        return $this;
    }

    public function withUserToken()
    {
        $userToken = $this->entity->getUserToken();
        if ($userToken !== null) {
            $this->entityDTO->userToken = $this->dtoBuilderFactory
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
