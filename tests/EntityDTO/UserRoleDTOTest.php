<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\UserRole;

class UserRoleDTOTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $userRole = new UserRole;

        $userRoleDTO = $userRole->getDTOBuilder()
            ->build();

        $this->assertTrue($userRoleDTO instanceof UserRoleDTO);
    }
}
