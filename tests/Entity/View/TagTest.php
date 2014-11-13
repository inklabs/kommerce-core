<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tag = new Entity\Tag;
        $this->tag->setName('Test Tag');

        $this->viewTag = Tag::factory($this->tag);
    }

    public function testBasic()
    {
        $viewTag = $this->viewTag->export();
        $this->assertEquals('Test Tag', $viewTag->name);
    }

    public function testWithAllData()
    {
        $this->tag->addImage(new Entity\Image);
        $this->tag->addProduct(new Entity\Product);

        $pricing = new Service\Pricing();

        $viewTag = $this->viewTag
            ->withAllData($pricing)
            ->export();
        $this->assertEquals('Test Tag', $viewTag->name);
    }
}
