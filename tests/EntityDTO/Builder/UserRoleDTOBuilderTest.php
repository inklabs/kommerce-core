<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class UserRoleDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $userRole = $this->dummyData->getUserRole();

        $userRoleDTO = $userRole->getDTOBuilder()
            ->build();

        $this->assertTrue($userRoleDTO instanceof UserRoleDTO);
    }
}
