<?php
namespace inklabs\kommerce\Entity;

class RoleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $role = new Role;
        $role->setid(1);
        $role->setName('admin');
        $role->setDescription('Test Description');

        $this->assertEquals(1, $role->getId());
        $this->assertEquals('admin', $role->getName());
        $this->assertEquals('Test Description', $role->getDescription());
    }
}
