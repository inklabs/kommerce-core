<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OptionValueTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $option = new Option;
        $option->setType(Option::TYPE_SELECT);
        $option->setName('Size');
        $option->setDescription('Shirt Size');

        $optionValue = new OptionValue;
        $optionValue->setSortOrder(0);
        $optionValue->setSku('MD');
        $optionValue->setName('Medium Shirt');
        $optionValue->setShippingWeight(16);
        $optionValue->setUnitPrice(500);
        $optionValue->setOption($option);

        $this->assertEntityValid($optionValue);
        $this->assertSame(0, $optionValue->getSortOrder());
        $this->assertSame('MD', $optionValue->getSku());
        $this->assertSame('Medium Shirt', $optionValue->getName());
        $this->assertSame(16, $optionValue->getShippingWeight());
        $this->assertTrue($optionValue->getOption() instanceof Option);
        $this->assertTrue($optionValue->getPrice() instanceof Price);
    }
}
