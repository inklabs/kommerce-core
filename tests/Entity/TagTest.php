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

        $this->product = new Product;
        $this->product->setSku('TST101');

        $this->tag->addProduct($this->product);
    }

    public function testGetData()
    {
        $expected = new \stdClass;
        $expected->id             = $this->tag->getId();
        $expected->name           = $this->tag->getName();
        $expected->description    = $this->tag->getDescription();
        $expected->defaultImage   = $this->tag->getDefaultImage();
        $expected->isProductGroup = $this->tag->getIsProductGroup();
        $expected->sortOrder      = $this->tag->getSortOrder();
        $expected->isVisible      = $this->tag->getIsVisible();

        $this->assertEquals($expected, $this->tag->getData());
    }

    public function testGetAllData()
    {
        $expected = new \stdClass;
        $expected->id             = $this->tag->getId();
        $expected->name           = $this->tag->getName();
        $expected->description    = $this->tag->getDescription();
        $expected->defaultImage   = $this->tag->getDefaultImage();
        $expected->isProductGroup = $this->tag->getIsProductGroup();
        $expected->sortOrder      = $this->tag->getSortOrder();
        $expected->isVisible      = $this->tag->getIsVisible();
        $expected->products       = [$this->product->getData()];

        $this->assertEquals($expected, $this->tag->getAllData());
    }
}
