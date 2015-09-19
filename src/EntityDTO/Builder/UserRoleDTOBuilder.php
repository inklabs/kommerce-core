<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\EntityDTO\UserRoleDTO;
use inklabs\kommerce\Lib\BaseConvert;

class UserRoleDTOBuilder
{
    /** @var UserRole */
    protected $userRole;

    /** @var UserRoleDTO */
    protected $userRoleDTO;

    public function __construct(UserRole $userRole)
    {
        $this->userRole = $userRole;

        $this->userRoleDTO = new UserRoleDTO;
        $this->userRoleDTO->id          = $this->userRole->getId();
        $this->userRoleDTO->encodedId   = BaseConvert::encode($this->userRole->getId());
        $this->userRoleDTO->name        = $this->userRole->getName();
        $this->userRoleDTO->description = $this->userRole->getDescription();
        $this->userRoleDTO->created     = $this->userRole->getCreated();
        $this->userRoleDTO->updated     = $this->userRole->getUpdated();
    }

    public function build()
    {
        return $this->userRoleDTO;
    }
}
