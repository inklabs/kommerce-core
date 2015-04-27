<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityTag = new Entity\Tag;
        $entityTag->addImage(new Entity\Image);
        $entityTag->addProduct(new Entity\Product);
        $entityTag->addOptionType(new Entity\OptionType\Option);

        $tag = $entityTag->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($tag->images[0] instanceof Image);
        $this->assertTrue($tag->products[0] instanceof Product);
        $this->assertTrue($tag->optionTypes[0] instanceof OptionType\OptionTypeInterface);
    }
}
