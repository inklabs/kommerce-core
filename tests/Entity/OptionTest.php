<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OptionTest extends DoctrineTestCase
{
    public function testCreateDefaults()
    {
        $option = new Option;

        $this->assertSame(Option::TYPE_SELECT, $option->getType());
        $this->assertSame('Select', $option->getTypeText());
        $this->assertSame(0, count($option->getTags()));
        $this->assertSame(0, count($option->getOptionProducts()));
        $this->assertSame(0, count($option->getOptionValues()));
    }

    public function testCreate()
    {
        $tag = $this->dummyData->getTag();
        $optionProduct = $this->dummyData->getOptionProduct();
        $optionValue = $this->dummyData->getOptionValue();

        $option = new Option;
        $option->setType(Option::TYPE_RADIO);
        $option->setName('Size');
        $option->setDescription('Shirt Size');
        $option->setSortOrder(0);
        $option->addTag($tag);
        $option->addOptionProduct($optionProduct);
        $option->addOptionValue($optionValue);

        $this->assertEntityValid($option);
        $this->assertSame(Option::TYPE_RADIO, $option->getType());
        $this->assertSame('Radio', $option->getTypeText());
        $this->assertSame($tag, $option->getTags()[0]);
        $this->assertSame($optionProduct, $option->getOptionProducts()[0]);
        $this->assertSame($optionValue, $option->getOptionValues()[0]);
    }
}
