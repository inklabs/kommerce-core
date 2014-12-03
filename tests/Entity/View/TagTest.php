<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityTag = new Entity\Tag;
        $entityTag->addImage(new Entity\Image);
        $entityTag->addProduct(new Entity\Product);
        $tag = Tag::factory($entityTag)
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Image', $tag->images[0]);
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Product', $tag->products[0]);
    }
}
