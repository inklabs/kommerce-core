<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserTokenType;
use inklabs\kommerce\EntityDTO\UserTokenTypeDTO;

class UserTokenTypeDTOBuilder
{
    /** @var UserTokenType */
    protected $orderStatusType;

    /** @var UserTokenTypeDTO */
    protected $orderStatusTypeDTO;

    public function __construct(UserTokenType $orderStatusType)
    {
        $this->orderStatusType = $orderStatusType;

        $this->orderStatusTypeDTO = new UserTokenTypeDTO;
        $this->orderStatusTypeDTO->id = $this->orderStatusType->getId();
        $this->orderStatusTypeDTO->name = $this->orderStatusType->getName();
        $this->orderStatusTypeDTO->nameMap = $this->orderStatusType->getNameMap();
    }

    public function build()
    {
        return $this->orderStatusTypeDTO;
    }
}
