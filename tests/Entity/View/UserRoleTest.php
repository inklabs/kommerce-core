<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class UserRoleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityUserRole = new Entity\UserRole;
        $userRole = $entityUserRole->getView();
        $this->assertTrue($userRole instanceof UserRole);
    }
}
