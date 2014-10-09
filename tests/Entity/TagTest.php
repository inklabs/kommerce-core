<?php
use inklabs\kommerce\Entity\Tag;

class TagTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers Tag::__construct
	 */
	public function test_construct()
	{
		$tag = new Tag;
		$tag->id = 1;
		$tag->name = 'Test Tag';
		$tag->description = 'Test Description';
		$tag->default_image = NULL;
		$tag->is_product_group = FALSE;
		$tag->sort_order = 0;
		$tag->visible = TRUE;
		$tag->created = new \DateTime('now', new \DateTimeZone('UTC'));
		$tag->updated = NULL;

		$this->assertEquals(1, $tag->id);
	}
}
