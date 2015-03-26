<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {

        $entityOption = new Entity\Option;

        $entityOptionValue = new Entity\OptionValue($entityOption);
        $entityOptionValue->setProduct(new Entity\Product);

        $entityOption->addOptionValue($entityOptionValue);
        $entityOption->addTag(new Entity\Tag);

        $option = $entityOption->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($option instanceof Option);
        $this->assertTrue($option->optionValues[0] instanceof OptionValue);
        $this->assertTrue($option->tags[0] instanceof Tag);
    }
}
