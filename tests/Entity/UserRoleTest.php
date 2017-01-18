<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UserRoleTest extends EntityTestCase
{
    public function testCreate()
    {
        $userRoleType = UserRoleType::admin();
        $userRole = new UserRole($userRoleType);

        $this->assertEntityValid($userRole);
        $this->assertSame($userRoleType, $userRole->getUserRoleType());
    }
}
