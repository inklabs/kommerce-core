<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityOption = new Entity\Option;
        $entityOption->addProduct(new Entity\Product);
        $entityOption->addTag(new Entity\Tag);

        $option = $entityOption->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($option instanceof Option);
        $this->assertTrue($option->products[0] instanceof Product);
        $this->assertTrue($option->tags[0] instanceof Tag);
    }
}
