<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class UserRoleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityUserRole = new Entity\UserRole;
        $userRole = $entityUserRole->getView()
            ->export();

        $this->assertTrue($userRole instanceof UserRole);
    }
}
