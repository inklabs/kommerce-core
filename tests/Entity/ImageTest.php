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
    }

    public function test()
    {
    }
}
