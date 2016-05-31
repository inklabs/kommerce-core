<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class UserRoleDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $userRole = $this->dummyData->getUserRole();

        $userRoleDTO = $this->getDTOBuilderFactory()
            ->getUserRoleDTOBuilder($userRole)
            ->build();

        $this->assertTrue($userRoleDTO instanceof UserRoleDTO);
    }
}
