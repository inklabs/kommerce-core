<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class OptionTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $option = new Option;

        $this->assertSame(0, count($option->getTags()));
        $this->assertSame(0, count($option->getOptionProducts()));
        $this->assertSame(0, count($option->getOptionValues()));
        $this->assertTrue($option->getType()->isSelect());
    }

    public function testCreate()
    {
        $tag = $this->dummyData->getTag();
        $optionType = $this->dummyData->getOptionType();

        $option = new Option;
        $option->setType($optionType);
        $option->setName('Size');
        $option->setDescription('Shirt Size');
        $option->setSortOrder(0);
        $option->addTag($tag);

        $optionProduct = $this->dummyData->getOptionProduct($option);
        $optionValue = $this->dummyData->getOptionValue($option);

        $this->assertEntityValid($option);
        $this->assertSame($optionType, $option->getType());
        $this->assertSame($tag, $option->getTags()[0]);
        $this->assertSame($optionProduct, $option->getOptionProducts()[0]);
        $this->assertSame($optionValue, $option->getOptionValues()[0]);
    }
}
