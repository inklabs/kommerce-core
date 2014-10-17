<?php
namespace inklabs\kommerce\Entity;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tag = new Tag;
        $this->tag->setName('Test Tag');
        $this->tag->setDescription('Test Description');
        $this->tag->setDefaultImage('http://lorempixel.com/400/200/');
        $this->tag->setIsProductGroup(false);
        $this->tag->setSortOrder(0);
        $this->tag->setIsVisible(true);
        $this->tag->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->tag->getId());
        $this->assertEquals('Test Tag', $this->tag->getName());
        $this->assertEquals('Test Description', $this->tag->getDescription());
        $this->assertEquals('http://lorempixel.com/400/200/', $this->tag->getDefaultImage());
        $this->assertEquals(false, $this->tag->getIsProductGroup());
        $this->assertEquals(0, $this->tag->getSortOrder());
        $this->assertEquals(true, $this->tag->getIsVisible());
        $this->assertEquals(0, count($this->tag->getProducts()));
    }
}
