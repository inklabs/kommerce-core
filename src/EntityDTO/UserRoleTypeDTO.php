<?php
namespace inklabs\kommerce\EntityDTO;

class UserRoleTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isAdmin;

    /** @var bool */
    public $isDeveloper;
}
