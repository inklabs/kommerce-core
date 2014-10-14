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
        $this->role->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetName()
    {
        $this->assertEquals('admin', $this->role->getName());
    }
}
