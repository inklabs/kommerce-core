<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityImage = new Entity\Image;
        $entityImage->setProduct(new Entity\Product);
        $entityImage->setTag(new Entity\Tag);

        $image = $entityImage->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($image->product instanceof Product);
        $this->assertTrue($image->tag instanceof Tag);
    }
}
