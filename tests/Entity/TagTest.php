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

        $this->product = new Product;
        $this->product->setSku('TST101');
        $this->tag->addProduct($this->product);

        $reflection = new \ReflectionClass('inklabs\kommerce\Entity\View\Tag');
        $this->expectedView = $reflection->newInstanceWithoutConstructor();
    }

    private function setupExpectedView()
    {
        $this->expectedView->id             = $this->tag->getId();
        $this->expectedView->slug           = 'test-tag';
        $this->expectedView->name           = $this->tag->getName();
        $this->expectedView->description    = $this->tag->getDescription();
        $this->expectedView->defaultImage   = $this->tag->getDefaultImage();
        $this->expectedView->isProductGroup = $this->tag->getIsProductGroup();
        $this->expectedView->sortOrder      = $this->tag->getSortOrder();
        $this->expectedView->isVisible      = $this->tag->getIsVisible();
    }

    public function testGetView()
    {
        $this->setupExpectedView();
        $this->expectedView = $this->expectedView->export();

        $this->assertEquals($this->expectedView, $this->tag->getView()->export());
    }

    // public function testGetAllData()
    // {
    //     $this->setupExpectedView();
    //     $this->expectedView->products = [$this->product->getView()->export()];
    //     $this->expectedView = $this->expectedView->export();
    //
    //     $this->assertEquals($this->expectedView, $this->tag->getView()->withAllData()->export());
    // }
}
