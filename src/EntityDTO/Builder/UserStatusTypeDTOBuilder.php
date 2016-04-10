<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\EntityDTO\UserStatusTypeDTO;

/**
 * @method UserStatusTypeDTO build()
 */
class UserStatusTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var UserStatusType */
    protected $type;

    /** @var UserStatusTypeDTO */
    protected $typeDTO;

    /**
     * @return UserStatusTypeDTO
     */
    protected function getTypeDTO()
    {
        return new UserStatusTypeDTO;
    }

    public function __construct(UserStatusType $type)
    {
        parent::__construct($type);

        $this->typeDTO->isInactive = $this->type->isInactive();
        $this->typeDTO->isActive = $this->type->isActive();
        $this->typeDTO->isLocked = $this->type->isLocked();
    }
}
