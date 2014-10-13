<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Image::__construct
     */
    public function testConstruct()
    {
        $image = new Image;
        $image->id = 1;
        $image->product_id = 1;
        $image->path = 'http://lorempixel.com/400/200/';
        $image->width = 400;
        $image->height = 200;
        $image->sort_order = 0;
        $image->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->assertEquals('1', $image->id);
    }
}
