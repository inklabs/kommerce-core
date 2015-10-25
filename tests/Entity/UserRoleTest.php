<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class UserRoleTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $userRole = new UserRole;
        $userRole->setName('Administrator');
        $userRole->setDescription('Admin account with access to everything.');

        $this->assertEntityValid($userRole);
        $this->assertSame('Administrator', $userRole->getName());
        $this->assertSame('Admin account with access to everything.', $userRole->getDescription());
    }
}
