<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\UserRole;

class UserRoleDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $userRole = new UserRole;

        $userRoleDTO = $userRole->getDTOBuilder()
            ->build();

        $this->assertTrue($userRoleDTO instanceof UserRoleDTO);
    }
}
