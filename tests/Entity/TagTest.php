<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $tag = new Tag;
        // $tag->id = 1;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setIsProductGroup(false);
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);
        $tag->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->assertEquals('Test Tag', $tag->getName());
    }
}
