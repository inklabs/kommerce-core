<?php
namespace inklabs\kommerce\EntityDTO;

class UserStatusTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isInactive;

    /** @var bool */
    public $isActive;

    /** @var bool */
    public $isLocked;
}
