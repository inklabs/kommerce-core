<?php
namespace inklabs\kommerce\Entity;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->image = new Image;
        $this->image->setPath('http://lorempixel.com/400/200/');
        $this->image->setWidth(400);
        $this->image->setHeight(200);
        $this->image->setSortOrder(0);

        $reflection = new \ReflectionClass('inklabs\kommerce\Entity\View\Image');
        $this->expectedView = $reflection->newInstanceWithoutConstructor();
    }

    public function testGetView()
    {
        $this->expectedView->id = $this->image->getId();

        $this->expectedView->path      = $this->image->getPath();
        $this->expectedView->width     = $this->image->getWidth();
        $this->expectedView->height    = $this->image->getHeight();
        $this->expectedView->sortOrder = $this->image->getSortOrder();

        $this->expectedView = $this->expectedView->export();
        $this->assertEquals($this->expectedView, $this->image->getView()->export());
    }

    public function testGetViewWithProduct()
    {
        $this->expectedView->id = $this->image->getId();

        $product = new Product;
        $product->setSku('TST101');
        $this->image->setProduct($product);

        $this->expectedView->path      = $this->image->getPath();
        $this->expectedView->width     = $this->image->getWidth();
        $this->expectedView->height    = $this->image->getHeight();
        $this->expectedView->sortOrder = $this->image->getSortOrder();
        $this->expectedView->product   = $product->getView()->export();

        $this->expectedView = $this->expectedView->export();
        $this->assertEquals($this->expectedView, $this->image->getView()->withProduct()->export());
    }

    public function testGetViewWithTag()
    {
        $this->expectedView->id = $this->image->getId();

        $tag = new Tag;
        $this->image->setTag($tag);

        $this->expectedView->path      = $this->image->getPath();
        $this->expectedView->width     = $this->image->getWidth();
        $this->expectedView->height    = $this->image->getHeight();
        $this->expectedView->sortOrder = $this->image->getSortOrder();
        $this->expectedView->tag       = $tag->getView()->export();

        $this->expectedView = $this->expectedView->export();
        $this->assertEquals($this->expectedView, $this->image->getView()->withTag()->export());
    }
}
