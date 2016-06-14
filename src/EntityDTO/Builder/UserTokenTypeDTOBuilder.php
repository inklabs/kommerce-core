<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserTokenType;
use inklabs\kommerce\EntityDTO\UserTokenTypeDTO;

/**
 * @method UserTokenTypeDTO build()
 */
class UserTokenTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var UserTokenType */
    protected $entity;

    /** @var UserTokenTypeDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new UserTokenTypeDTO;
    }

    protected function preBuild()
    {
        $this->entityDTO->isInternal = $this->entity->isInternal();
        $this->entityDTO->isGoogle   = $this->entity->isGoogle();
        $this->entityDTO->isFacebook = $this->entity->isFacebook();
        $this->entityDTO->isTwitter  = $this->entity->isTwitter();
        $this->entityDTO->isYahoo    = $this->entity->isYahoo();
    }
}
