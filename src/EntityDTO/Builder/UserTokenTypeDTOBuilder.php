<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserTokenType;
use inklabs\kommerce\EntityDTO\AbstractIntegerTypeDTO;
use inklabs\kommerce\EntityDTO\UserTokenTypeDTO;

class UserTokenTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var UserTokenType */
    protected $type;

    /** @var UserTokenTypeDTO */
    protected $typeDTO;

    /**
     * @return AbstractIntegerTypeDTO
     */
    protected function getTypeDTO()
    {
        return new UserTokenTypeDTO;
    }
}
