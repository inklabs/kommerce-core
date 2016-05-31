<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserLoginResultType;
use inklabs\kommerce\EntityDTO\UserLoginResultTypeDTO;

/**
 * @method UserLoginResultTypeDTO build()
 */
class UserLoginResultTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var UserLoginResultType */
    protected $type;

    /** @var UserLoginResultTypeDTO */
    protected $typeDTO;

    protected function getTypeDTO()
    {
        return new UserLoginResultTypeDTO;
    }

    protected function preBuild()
    {
        $this->typeDTO->isFail    = $this->type->isFail();
        $this->typeDTO->isSuccess = $this->type->isSuccess();
    }
}
