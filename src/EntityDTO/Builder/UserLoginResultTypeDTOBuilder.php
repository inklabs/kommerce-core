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

    /**
     * @return UserLoginResultTypeDTO
     */
    protected function getTypeDTO()
    {
        return new UserLoginResultTypeDTO;
    }

    public function __construct(UserLoginResultType $type)
    {
        parent::__construct($type);

        $this->typeDTO->isFail = $this->type->isFail();
        $this->typeDTO->isSuccess = $this->type->isSuccess();
    }
}
