<?php
use inklabs\kommerce\Kommerce;

class KommerceTest extends PHPUnit_Framework_TestCase
{
	public function test_base_decode()
	{
		$this->assertSame(
			140,
			Kommerce::base_decode('3W', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
		);
	}

	public function test_base_encode()
	{
		$this->assertSame(
			'3W',
			Kommerce::base_encode(140, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
		);
	}
}
