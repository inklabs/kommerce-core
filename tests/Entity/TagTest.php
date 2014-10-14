<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tag = new Tag;
        $this->tag->setName('Test Tag');
        $this->tag->setDescription('Test Description');
        $this->tag->setIsProductGroup(false);
        $this->tag->setSortOrder(0);
        $this->tag->setIsVisible(true);
        $this->tag->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetName()
    {
        $this->assertEquals('Test Tag', $this->tag->getName());
    }
}
