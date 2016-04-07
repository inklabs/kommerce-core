<?php
namespace inklabs\kommerce\EntityDTO;

class UserRoleDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $name;

    /** @var string */
    public $description;
}
