<?php
use inklabs\kommerce\Entity\Role;

class RoleTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers Role::__construct
	 */
	public function test_construct()
	{
		$role = new Role;
		$role->id = 1;
		$role->name = 'admin';
		$role->description = 'Administrative user, has access to everything';
		$role->created = new \DateTime('now', new \DateTimeZone('UTC'));

		$this->assertEquals(1, $role->id);
	}
}
