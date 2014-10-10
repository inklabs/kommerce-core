<?php
use inklabs\kommerce\Entity\User;

class UserTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers User::__construct
	 */
	public function test_construct()
	{
		$user = new User;
		$user->id = 1;
		$user->email = 'test@example.com';
		$user->username = 'test';
		$user->password = 'xxxx';
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->logins = 0;
		$user->last_login = NULL;
		$user->created = new \DateTime('now', new \DateTimeZone('UTC'));
		$user->updated = NULL;

		$this->assertEquals(1, $user->id);
	}
}
