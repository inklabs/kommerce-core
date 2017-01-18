<?php
namespace inklabs\kommerce\EntityDTO;

class UserRoleDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var UserRoleTypeDTO */
    public $userRoleType;
}
