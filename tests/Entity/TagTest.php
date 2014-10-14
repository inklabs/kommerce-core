<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $tag = new Tag;
        $tag->id = 1;
        $tag->name = 'Test Tag';
        $tag->description = 'Test Description';
        $tag->default_image = null;
        $tag->is_product_group = false;
        $tag->sort_order = 0;
        $tag->visible = true;
        $tag->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $tag->updated = null;

        $this->assertEquals(1, $tag->id);
    }
}
