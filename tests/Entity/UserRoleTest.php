<?php
namespace inklabs\kommerce\Entity;

class UserRoleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $userRole = new UserRole;
        $userRole->setId(1);
        $userRole->setName('Administrator');
        $userRole->setDescription('Admin account with access to everything.');

        $this->assertEquals(1, $userRole->getId());
        $this->assertEquals('Administrator', $userRole->getName());
        $this->assertEquals('Admin account with access to everything.', $userRole->getDescription());
    }
}
