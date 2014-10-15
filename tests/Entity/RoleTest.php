<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Role;

class RoleTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->role = new Role;
        $this->role->setName('admin');
        $this->role->setDescription('Administrative user, has access to everything');
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->role->getId());
        $this->assertEquals('admin', $this->role->getName());
        $this->assertEquals('Administrative user, has access to everything', $this->role->getDescription());
    }
}
