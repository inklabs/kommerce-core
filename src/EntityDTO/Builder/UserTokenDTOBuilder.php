<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\EntityDTO\UserTokenDTO;

class UserTokenDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var UserToken */
    protected $entity;

    /** @var UserTokenDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(UserToken $userToken, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $userToken;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new UserTokenDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->userAgent = $this->entity->getUserAgent();
        $this->entityDTO->ip4       = $this->entity->getIp4();
        $this->entityDTO->expires   = $this->entity->getExpires();

        $this->entityDTO->type = $this->dtoBuilderFactory
            ->getUserTokenTypeDTOBuilder($this->entity->getType())
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

    public function withAllData()
    {
        return $this
            ->withUser();
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
