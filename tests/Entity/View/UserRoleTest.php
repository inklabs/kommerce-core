<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class UserRoleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityUserRole = new Entity\UserRole;
        $entityUserRole->setUser(new Entity\User);

        $userRole = $entityUserRole->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($userRole instanceof UserRole);
        $this->assertTrue($userRole->user instanceof User);
    }
}
