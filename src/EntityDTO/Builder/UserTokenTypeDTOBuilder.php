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

    /**
     * @return UserTokenTypeDTO
     */
    protected function getTypeDTO()
    {
        return new UserTokenTypeDTO;
    }

    public function __construct(UserTokenType $type)
    {
        parent::__construct($type);

        $this->typeDTO->isInternal = $this->type->isInternal();
        $this->typeDTO->isGoogle = $this->type->isGoogle();
        $this->typeDTO->isFacebook = $this->type->isFacebook();
        $this->typeDTO->isTwitter = $this->type->isTwitter();
        $this->typeDTO->isYahoo = $this->type->isYahoo();
    }
}
