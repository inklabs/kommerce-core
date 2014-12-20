<?php
namespace inklabs\kommerce\Entity;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $tag = new Tag;
        $tag->setId(1);
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);
        $tag->setIsActive(true);
        $tag->addProduct(new Product);
        $tag->addImage(new Image);

        $this->assertEquals(1, $tag->getId());
        $this->assertEquals('Test Tag', $tag->getName());
        $this->assertEquals('Test Description', $tag->getDescription());
        $this->assertEquals('http://lorempixel.com/400/200/', $tag->getDefaultImage());
        $this->assertEquals(0, $tag->getSortOrder());
        $this->assertTrue($tag->getIsVisible());
        $this->assertTrue($tag->getIsActive());
        $this->assertTrue($tag->getProducts()[0] instanceof Product);
        $this->assertTrue($tag->getImages()[0] instanceof Image);
    }
}
