<?php
use inklabs\kommerce\Entity\UserToken;

class UserTokenTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers UserToken::__construct
	 */
	public function test_construct()
	{
		$user_token = new UserToken;
		$user_token->id = 1;
		$user_token->user_agent = 'XXX';
		$user_token->token = 'XXX';
		$user_token->type = 'XXX';
		$user_token->created = new \DateTime('now', new \DateTimeZone('UTC'));
		$user_token->expires = NULL;

		$this->assertEquals(1, $user_token->id);
	}
}
