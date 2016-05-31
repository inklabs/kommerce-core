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
    protected $type;

    /** @var UserTokenTypeDTO */
    protected $typeDTO;

    protected function getTypeDTO()
    {
        return new UserTokenTypeDTO;
    }

    protected function preBuild()
    {
        $this->typeDTO->isInternal = $this->type->isInternal();
        $this->typeDTO->isGoogle   = $this->type->isGoogle();
        $this->typeDTO->isFacebook = $this->type->isFacebook();
        $this->typeDTO->isTwitter  = $this->type->isTwitter();
        $this->typeDTO->isYahoo    = $this->type->isYahoo();
    }
}
