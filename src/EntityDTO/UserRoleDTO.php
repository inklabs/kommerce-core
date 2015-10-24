<?php
namespace inklabs\kommerce\EntityDTO;

class UserRoleDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $encodedId;
    public $name;
    public $description;
}
