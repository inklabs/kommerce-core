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
        $tag = $entityTag->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($tag->images[0] instanceof Image);
        $this->assertTrue($tag->products[0] instanceof Product);
    }
}
