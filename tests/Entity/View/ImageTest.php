<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityImage = new Entity\Image;
        $entityImage->setProduct(new Entity\Product);
        $entityImage->setTag(new Entity\Tag);

        $image = Image::factory($entityImage)
            ->withAllData()
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Product', $image->product);
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Tag', $image->tag);
    }
}
