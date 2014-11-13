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

    public function test()
    {
    }
}
