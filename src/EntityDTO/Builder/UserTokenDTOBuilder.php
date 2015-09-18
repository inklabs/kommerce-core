<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\EntityDTO\UserTokenDTO;

class UserTokenDTOBuilder extends AbstractDTOBuilder
{
    /** @var UserToken */
    protected $entity;

    /** @var UserTokenDTO */
    protected $entityDTO;

    public function __construct(UserToken $userToken)
    {
        $this->entity = $userToken;

        $this->entityDTO = new UserTokenDTO;
        $this->entityDTO->userAgent = $this->entity->getUserAgent();
        $this->entityDTO->token     = $this->entity->getToken();
        $this->entityDTO->expires   = $this->entity->getExpires();
        $this->entityDTO->type      = $this->entity->getType();

        $this->setId();
        $this->setTimestamps();
    }

    public function withUser()
    {
        $user = $this->entity->getUser();
        if ($user !== null) {
            $this->entityDTO->user = $user->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withUser();
    }
}
