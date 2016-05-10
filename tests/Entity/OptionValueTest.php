<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class OptionValueTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $option = $this->dummyData->getOption();
        $optionValue = new OptionValue($option);

        $this->assertSame(null, $optionValue->getSortOrder());
        $this->assertSame(null, $optionValue->getSku());
        $this->assertSame(null, $optionValue->getName());
        $this->assertSame(null, $optionValue->getShippingWeight());
        $this->assertSame($option, $optionValue->getOption());
        $this->assertTrue($optionValue->getPrice() instanceof Price);
    }

    public function testCreate()
    {
        $option = $this->dummyData->getOption();

        $optionValue = new OptionValue($option);
        $optionValue->setSortOrder(2);
        $optionValue->setSku('MD');
        $optionValue->setName('Medium Shirt');
        $optionValue->setShippingWeight(16);
        $optionValue->setUnitPrice(500);

        $this->assertEntityValid($optionValue);
        $this->assertSame('MD', $optionValue->getSku());
        $this->assertSame('Medium Shirt', $optionValue->getName());
        $this->assertSame(16, $optionValue->getShippingWeight());
        $this->assertSame(2, $optionValue->getSortOrder());
        $this->assertSame($option, $optionValue->getOption());
        $this->assertTrue($optionValue->getPrice() instanceof Price);
    }
}
